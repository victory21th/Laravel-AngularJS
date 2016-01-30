'use strict';
app.factory('sessionService',['',function(){
	return function name(){
		set:function(key,value){
			return sessionStorage.setItem(key,value);
		},
		get:function(){
			return sessionStorage.getItem(key);
		},
		destory:function(){
			return sessionStorage.removeItem(key);
			
		},
	};
}])