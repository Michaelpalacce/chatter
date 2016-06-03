<?php

namespace Chatter;
use Chatter\Status;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table='users';
    protected $fillable = [
        'username', 'email', 'password','first_name','last_name','location'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getName(){
        if($this->first_name&&$this->last_name){
            return "$this->first_name $this->last_name";
        }

        if($this->first_name){
            return "$this->first_name";
        }
        return null;
    }

    public function getNameOrUserName(){
        return $this->getName()?:$this->username;
    }

    public function getFirstNameOrUsername(){
        return $this->first_name?:$this->username;
    }

    public function getAvatarUrl(){
        return "http://www.gravatar.com/avatar/{{md5($this->email)}}?d=mm&s=40";
    }

    public function statuses(){
        return $this->hasMany('Chatter\Status','user_id');
    }

    public function friendsOfMine(){
        return $this->belongsToMany('Chatter\User','friends','user_id','friend_id');
    }

    public function friendOf(){
        return $this->belongsToMany('Chatter\User','friends','friend_id','user_id');
    }

    public function friends(){
        return $this->friendsOfMine()->wherePivot('accepted',true)->get()
            ->merge($this->friendOf()->wherePivot('accepted',true)->get());
    }

    public function friendRequests(){
        return $this->friendsOfMine()->wherePivot('accepted',false)->get();
    }

    public function friendRequestsPending(){
        return $this->friendOf()->wherePivot('accepted',false)->get();
    }

    public function hasFriendRequestPending(User $user){
        return (bool) $this->friendRequestsPending()->where('id',$user->id)->count();
    }

    public function hasFriendRequestRecieved(User $user){
        return (bool) $this->friendRequests()->where('id',$user->id)->count();
    }

    public function addFriend(User $user){
        $this->friendOf()->attach($user->id);
    }

    public function acceptFriendRequest(User $user){
        $this->friendRequests()->where('id',$user->id)->first()->pivot->update([
            'accepted'=>true,
        ]);
    }

    public function isFriendsWith(User $user){
        return (bool) $this->friends()->where('id',$user->id)->count();
    }

    public function likes(){
        return $this->hasMany('Chatter\Like','user_id');
    }

    public function hasLikedStatus(Status $status){
        return (bool) $status->likes()->where('user_id',$this->id)->count();
    }

    public function deleteFriend(User $user){
        $this->friendOf()->detach($user->id);
        $this->friendsOfMine()->detach($user->id);
    }

    public function galleries(){
        $this->hasMany('Chatter\Gallery');
    }

    public function logInStat(){
        $this->logged=true;
        $this->update();
    }

    public function logOutStat(){
        $this->logged=false;
        $this->update();
    }

    public function scopeLike($query, $field, $value){
        return $query->where($field, 'LIKE', "%$value%");
    }
}
