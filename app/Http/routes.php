<?php

/*
 * Home
 */
Route::get('/',[
    'uses'=>'HomeController@index',
    'as'=>'home'
]);


/*
 * Alert
 */
Route::get('/alert',function(){
    return redirect()->route('home')->with('info','You Have Signed Up!');
});



/*
 * Auth
 */

Route::get('/signup',[
    'uses'=>'AuthController@getSignUp',
    'as'=>'auth.signup',
    'middleware'=>['guest']
]);

Route::post('/signup',[
    'uses'=>'AuthController@postSignUp',
    'middleware'=>['guest']
]);

Route::get('/signin',[
    'uses'=>'AuthController@getSignIn',
    'as'=>'auth.signin',
    'middleware'=>['guest']
]);

Route::post('/signin',[
    'uses'=>'AuthController@postSignIn',
    'middleware'=>['guest']
]);

Route::get('/signout',[
    'uses'=>'AuthController@getSignOut',
    'as'=>'auth.signout'
]);

/*
 * Search
 */

Route::get('/search',[
    'uses'=>'SearchController@getResults',
    'as'=>'search.results',
    'middleware'=>['auth']
]);

/*
 *  User Profile
 */

Route::get('/user/{username}',[
    'uses'=>'ProfileController@getProfile',
    'as'=>'profile.index',
    'middleware'=>['auth']
]);

Route::get('/profile/edit',[
    'uses'=>'ProfileController@getEdit',
    'as'=>'profile.edit',
    'middleware'=>['auth']
]);

//Route::get('profile/edit','ProfileController@getEdit');
//Route::resource('user','ProfileController');

Route::post('/profile/edit',[
    'uses'=>'ProfileController@postEdit',
    'middleware'=>['auth'],
]);

Route::post('/profile/{statusId}/reply',[
    'uses'=>'ProfileController@postReply',
    'as'=>'status.profile.reply',
    'middleware'=>['auth']
]);

/*
 *  Friends
 */


Route::get('/friends',[
    'uses'=>'FriendController@getIndex',
    'as'=>'friend.index',
    'middleware'=>['auth']
]);

Route::get('/friends/add/{username}',[
    'uses'=>'FriendController@getAdd',
    'as'=>'friend.add',
    'middleware'=>['auth']
]);

Route::get('/friends/accept/{username}',[
    'uses'=>'FriendController@getAccept',
    'as'=>'friend.accept',
    'middleware'=>['auth']
]);

Route::post('/friends/delete/{username}',[
    'uses'=>'FriendController@postDelete',
    'as'=>'friend.delete',
    'middleware'=>['auth']
]);


/*
 * Statuses
 */

Route::post('/status',[
    'uses'=>'StatusController@postStatus',
    'as'=>'status.post',
    'middleware'=>['auth']
]);

Route::post('/status/{statusId}/reply',[
    'uses'=>'StatusController@postReply',
    'as'=>'status.reply',
    'middleware'=>['auth']
]);


Route::get('/status/{statusId}/like',[
    'uses'=>'StatusController@getLike',
    'as'=>'status.like',
    'middleware'=>['auth']
]);

Route::post('/hashtag',[
    'uses'=>'StatusController@postHashtagSearch',
    'as'=>'hashtag.search',
    'middleware'=>['auth']
]);


/*
 * Messenger
 */

Route::get('/messenger',[
    'uses'=>'MessageController@getChatters',
    'as'=>'messenger',
    'middleware'=>['auth']
]);

Route::get('/messenger/conversation/{id}',[
    'uses'=>'MessageController@getConversation',
    'as'=>'messenger.conversation',
    'middleware'=>['auth']
]);



Route::post('/messenger/send',[
    'uses'=>'MessageController@sendMessage',
    'as'=>'messenger.send',
    'middleware'=>['auth']
]);



Route::post('/messenger/notTyping',[
    'uses'=>'MessageController@postRetrieve',
    'as'=>'messenger.notTyping',
    'middleware'=>['auth']
]);


Route::post('/messenger/isTyping',[
    'uses'=>'MessageController@postRetrieve',
    'as'=>'messenger.isTyping',
    'middleware'=>['auth']
]);
Route::post('/messenger/retrieve',[
    'uses'=>'MessageController@postRetrieve',
    'as'=>'messenger.retrieve',
    'middleware'=>['auth']
]);

Route::post('/messenger/typing',[
    'uses'=>'MessageController@postTyping',
    'as'=>'messenger.typing',
    'middleware'=>['auth']
]);

/*
 * Gallery
 */


Route::get('/gallery/list',[
    'uses'=>'GalleryController@getList',
    'as'=>'gallery.list',
    'middleware'=>['auth']
]);

Route::post('/gallery/save',[
    'uses'=>'GalleryController@postSave',
    'as'=>'gallery.save',
    'middleware'=>['auth']
]);

Route::get('/gallery/view/{id}',[
    'uses'=>'GalleryController@getGallery',
    'as'=>'gallery.view',
    'middleware'=>['auth']
]);

Route::get('/gallery/delete/{id}',[
    'uses'=>'GalleryController@postDeleteGallery',
    'as'=>'gallery.delete',
    'middleware'=>['auth']
]);

Route::post('/image/upload',[
    'uses'=>'ImageController@postUploadImage',
    'as'=>'image.upload',
    'middleware'=>['auth']
]);

Route::get('/image/delete/{id}',[
    'uses'=>'ImageController@getDeleteImage',
    'as'=>'image.delete',
    'middleware'=>['auth']
]);

Route::get('/image/slideshow/{galleryId}/{picId}',[
    'uses'=>'ImageController@getSlideshow',
    'as'=>'image.slideshow',
    'middleware'=>['auth'],

]);


/*
 * ToDo
 */

Route::get('/ToDo',[
    'uses'=>'ToDoController@getToDos',
    'as'=>'todo.index',
    'middleware'=>['auth']
]);

Route::post('/ToDo',[
    'uses'=>'ToDoController@postNewToDo',
    'middleware'=>['auth']
]);

Route::post("/ToDo/complete",[
    'uses'=>'ToDoController@postComplete',
    'as'=>'todo.complete',
    'middleware'=>['auth']
]);