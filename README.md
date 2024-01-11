README.MD <br/><br/>

Clone the Repo: <br/>
> git clone https://github.com/Romeho3455/Exercise_ipra.git<br/>
> cd Exercise_ipra<br/>
> composer install or composer update<br/>
> copy .env.example .env<br/>
> php artisan key:generate<br/>
> php artisan storage:link<br/>
> database name: exercise_ipra <br/>
> Create mysql datatable called exercise_ipra <br/>
> To migrate tables and seed all data use command: <b>php artisan database:setup</b><br/>
> php artisan serve<br/>
http://127.0.0.1:8000/<br/><br/>


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
