<?php

namespace App\Http\Controllers\api\v1;

use App\Services\CustomLogger;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Validator;
use Illuminate\Validation\Rule;

use App\Models\ticket;
use App\Models\comments;

class TicketController extends Controller
{

    public $channel = "Ticket";

    public function index()
    {
      $method = "Index";
          try {
              $data = ticket::all();

              $logMessage = "Received ticket data successfully.";
              CustomLogger::logMessage($logMessage,$this->channel,$method);

              return response()->json([
                  'status' => true,
                  'message' => 'Data received',
                  'data' => $data,
              ])->setStatusCode(200);

          } catch (\Exception $e) {
              $logMessage = "Error received on receiving data: " . $e->getMessage();
              CustomLogger::logMessage($logMessage,$this->channel,$method);

              return response()->json([
                  'status' => false,
                  'message' => 'Failed to retrieve ticket data',
                  'error' => $e->getMessage(),
              ])->setStatusCode(500);
          }
    }

    public function store(Request $request)
    {

        $method = "Store";

          $validator = Validator::make(
                    $request->all(),
                    [
                      "name" => ["required", Rule::unique('tickets', 'name')],
                      "content" => ["required"],
                      "creator" => ["required"],
                      "tester" => ["required"],
                      "artist" => ["required"],
                      "status" => ["required", "exists:statuses,id"],
                      "ticket_type" => ["required", "exists:ticket_types,id"]
                    ]
          ); //giving validation properties , to check inserted data

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "errors" => $validator->messages(),
            ])->setStatusCode(422); // Unprocessable Entity
        } //if any error receved validator will describe it

        try { //trying to store valid data to database
                $post = ticket::create([
                  "name" => $request -> name,
                  "content" => $request -> content,
                  "creator" => $request -> creator,
                  "tester" => $request -> tester,
                  "artist" => $request -> artist,
                  "status" => $request -> status,
                  "ticket_type" => $request -> ticket_type
                ]);

                  $logMessage = "New ticked stored.";
                  CustomLogger::logMessage($logMessage,$this->channel,$method); //sending log message to function

                    return response()->json([
                          "status" => true,
                          "post" => $post,
                    ])->setStatusCode(200);

        } catch (\Exception $e) { //if error received
            $logMessage = "Error received on receiving data: " . $e->getMessage();
            CustomLogger::logMessage($logMessage,$this->channel,$method);

            return response()->json([
                'status' => false,
                'message' => 'Failed to store ticket data',
                'error' => $e->getMessage(),
            ])->setStatusCode(500);
        }

    }

     public function show($id)
     {
         $ticket = ticket::find($id);
         $method = "Show";
         if (!$ticket) {
             return response()->json([
                 "status" => false,
                 "message" => "Ticket not found"
             ])->setStatusCode(404);
         }

         // If the ticket is found, we will return it

         $logMessage = "A ticket with id: " . $id . " was called and showed";
         CustomLogger::logMessage($logMessage,$this->channel,$method);

         return response()->json([
             "status" => true,
             "ticket" => $ticket,
         ])->setStatusCode(200);

     }

     public function update(Request $request, $id)
     {
          $method = "Update";

         $validator = Validator::make(
             $request->all(),
             [
                 "name" => ["required", Rule::unique('tickets', 'name')],
                 "content" => ["required"],
                 "creator" => ["required"],
                 "tester" => ["required"],
                 "artist" => ["required"],
                 "status" => ["required", "exists:statuses,id"],
                 "ticket_type" => ["required", "exists:ticket_types,id"]
             ]
         );

         if ($validator->fails()) {
             return response()->json([
                 "status" => false,
                 "errors" => $validator->messages(),
             ])->setStatusCode(422); // Unprocessable Entity
         }

         $ticket = ticket::find($id);

         if (!$ticket) {
             return response()->json([
                 "status" => false,
                 "message" => "Ticket not found"
             ])->setStatusCode(404);
         }

         try {
                 $ticket->update([
                     "name" => $request->input('name'),
                     "content" => $request->input('content'),
                     "creator" => $request->input('creator'),
                     "tester" => $request->input('tester'),
                     "artist" => $request->input('artist'),
                     "status" => $request->input('status'),
                     "ticket_type" => $request->input('ticket_type'),
                 ]);

                 $logMessage = "Ticket with id: " . $id . " was successfully updated";
                 CustomLogger::logMessage($logMessage,$this->channel,$method);

                 return response()->json([
                     "status" => true,
                     "message" => "Ticket updated successfully",
                     "ticket" => $ticket,
                 ])->setStatusCode(200);

        }catch (\Exception $e) { //if error received
            $logMessage = "Error received on receiving data: " . $e->getMessage();
            CustomLogger::logMessage($logMessage,$this->channel,$method);

            return response()->json([
                'status' => false,
                'message' => 'Failed to store ticket data',
                'error' => $e->getMessage(),
            ])->setStatusCode(500);
        }
     }

      public function destroy($id)
      {
          // Find the ticket
          $method = "destroy";
          $ticket = Ticket::find($id);

          // Check if the ticket exists
          if (!$ticket) {
              return response()->json([
                  'status' => false,
                  'message' => 'Ticket not found',
              ])->setStatusCode(404);
          }

          try{
                $commentsToDelete = comments::where('ticket_id', $id)
                        ->orWhere('parent_comment_id', $id)
                        ->get();

                    foreach ($commentsToDelete as $comment) {
                        $comment->delete();
                    }

                    $ticket->delete();

                    $logMessage = "Ticket with id". $id . " was successfully deleted";
                    CustomLogger::logMessage($logMessage,$this->channel,$method);

                    return response()->json([
                        'status' => true,
                        'message' => 'Ticket and associated comments deleted successfully',
                    ]);

            }catch (\Exception $e) { //if error received
                $logMessage = "Error received on receiving data: " . $e->getMessage();
                CustomLogger::logMessage($logMessage,$this->channel,$method);

                return response()->json([
                    'status' => false,
                    'message' => 'Failed to delete ticket data',
                    'error' => $e->getMessage(),
                ])->setStatusCode(500);
            }

      }

      public function addComment(Request $request, $ticketId)
      {
          $method="addComment";
          $ticket = ticket::find($ticketId);

          if (!$ticket) {
              return response()->json([
                  'status' => false,
                  'message' => 'Ticket not found',
              ])->setStatusCode(404);
          }

          $validator = Validator::make(
              $request->all(),
              [
                'comment' => ["required","string"]
              ]
          );

          if ($validator->fails()) {
              return response()->json([
                  "status" => false,
                  "errors" => $validator->messages(),
              ])->setStatusCode(422); // Unprocessable Entity
          }

                  try{
                      $post = comments::create([
                        "ticket_id" => $ticketId,
                        "comment" => $request -> comment
                      ]);

                      $logMessage = "A new Comment was written";
                      CustomLogger::logMessage($logMessage,$this->channel,$method);

                      return response()->json([
                          'status' => true,
                          'message' => 'Comment added successfully',
                          'comment' => $post
                      ])->setStatusCode(201); // 201 Created

                    }catch (\Exception $e) { //if error received
                          $logMessage = "Error received on receiving data: " . $e->getMessage();
                          CustomLogger::logMessage($logMessage,$this->channel,$method);

                          return response()->json([
                              'status' => false,
                              'message' => 'Failed to store comment',
                              'error' => $e->getMessage(),
                          ])->setStatusCode(500);
                      }
      }


      public function answerComment(Request $request, $ticketId, $commentId)
      {
          $ticket = ticket::find($ticketId);

          if (!$ticket) {
              return response()->json([
                  'status' => false,
                  'message' => 'Ticket not found',
              ])->setStatusCode(404);
          }

          $comment = comments::find($commentId);
          if (!$comment){
            return response()->json([
                'status' => false,
                'message' => 'Comment not found',
            ])->setStatusCode(404);
          }

          $validator = Validator::make(
              $request->all(),
              [
                'comment' => ["required","string"]
              ]
          );

          if ($validator->fails()) {
              return response()->json([
                  "status" => false,
                  "errors" => $validator->messages(),
              ])->setStatusCode(422); // Unprocessable Entity
          }

            try{
                  $post = comments::create([
                    "ticket_id" => $ticketId,
                    "parent_comment_id" => $commentId,
                    "comment" => $request -> comment
                  ]);

                  $logMessage = "A new answer was written";
                  CustomLogger::logMessage($logMessage,$this->channel,$method);

                  return response()->json([
                      'status' => true,
                      'message' => 'You answered comment successfully',
                      'comment' => $post
                  ])->setStatusCode(201); // 201 Created

            }catch (\Exception $e) { //if error received
                    $logMessage = "Error received on receiving data: " . $e->getMessage();
                    CustomLogger::logMessage($logMessage,$this->channel,$method);

                    return response()->json([
                        'status' => false,
                        'message' => 'Failed to answer comment',
                        'error' => $e->getMessage(),
                    ])->setStatusCode(500);
                }
      }
}
