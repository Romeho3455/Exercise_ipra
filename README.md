README.MD <br/><br/>

Duomenu bazės pavadinimas: <b>exercise_ipra</b> <br/>
Kad sukelti migracijas ir testinius duomenys, yra sukurta komanda: <b>php artisan database:setup</b><br/><br/>

<b>Api nuorodų sarašas:</b><br/><br/>

tickets.index -> suteikia užduočių sarašą.<br/>
tickets.store -> naujos užduoties įvedimas.<br/>
tickets.show -> suteikia informaciją apie pasirinktą užduotį.<br/>
tickets.update -> atnaujina informaciją<br/>
tickets.destroy -> ištrina užduotį<br/><br/>

comment.store -> sukurią komentarą<br/>
comment.answer -> atsako į komentarą.<br/>

GET  | api/v1/tickets                                              | tickets.index <br/>
POST | api/v1/tickets                                              | tickets.store <br/>
POST | api/v1/tickets/{ticketId}/store/comments                    | comment.store <br/>
POST | api/v1/tickets/{ticketId}/store/comments/{commentId}/answer | comment.answer <br/>
GET  | api/v1/tickets/{ticket}                                     | tickets.show <br/>
PUT  | api/v1/tickets/{ticket}                                     | tickets.update  <br/>
DELETE| api/v1/tickets/{ticket}                                    | tickets.destroy <br/><br/><br/>

Api buvo tikrintas naudojant <b>Postman</b> aplikaciją.
