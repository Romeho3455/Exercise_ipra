README.MD

Duomenu bazės pavadinimas: <b>exercise_ipra</b>
Kad sukelti migracijas ir testinius duomenys, yra sukurta komanda: <b>php artisan database:setup</b>

<b>Api nuorodų sarašas:</b>

tickets.index -> suteikia užduočių sarašą.
tickets.store -> naujos užduoties įvedimas.
tickets.show -> suteikia informaciją apie pasirinktą užduotį.
tickets.update -> atnaujina informaciją
tickets.destroy -> ištrina užduotį

comment.store -> sukurią komentarą
comment.answer -> atsako į komentarą.

--------+-----------+-------------------------------------------------------------+-----------------+------------------------------------------------------------+------------+
| Domain | Method    | URI                                                         | Name            | Action                                                     | Middleware |
+--------+-----------+-------------------------------------------------------------+-----------------+------------------------------------------------------------+------------+
|        | GET|HEAD  | /                                                           |                 | Closure                                                    | web        |
|        | GET|HEAD  | api/v1/tickets                                              | tickets.index   | App\Http\Controllers\api\v1\TicketController@index         | api        |
|        | POST      | api/v1/tickets                                              | tickets.store   | App\Http\Controllers\api\v1\TicketController@store         | api        |
|        | POST      | api/v1/tickets/{ticketId}/store/comments                    | comment.store   | App\Http\Controllers\api\v1\TicketController@addComment    | api        |
|        | POST      | api/v1/tickets/{ticketId}/store/comments/{commentId}/answer | comment.answer  | App\Http\Controllers\api\v1\TicketController@answerComment | api        |
|        | GET|HEAD  | api/v1/tickets/{ticket}                                     | tickets.show    | App\Http\Controllers\api\v1\TicketController@show          | api        |
|        | PUT|PATCH | api/v1/tickets/{ticket}                                     | tickets.update  | App\Http\Controllers\api\v1\TicketController@update        | api        |
|        | DELETE    | api/v1/tickets/{ticket}                                     | tickets.destroy | App\Http\Controllers\api\v1\TicketController@destroy       | api        |
|        | GET|HEAD  | sanctum/csrf-cookie                                         |                 | Laravel\Sanctum\Http\Controllers\CsrfCookieController@show | web        |
+--------+-----------+-------------------------------------------------------------+-----------------+------------------------------------------------------------+------------+

Api buvo tikrintas naudojant Postman aplikaciją.
