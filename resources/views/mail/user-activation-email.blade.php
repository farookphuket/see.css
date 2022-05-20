@extends('x')

@section('meta_title','sent greeting to new user')

@section('content')

   <div style="background-color:#e7e7e7;">
        <div style="background-color:white;color:blue;padding:2px;">
            <h1>Dear {{$name}} you have registerd with {{$website}}!</h1>
            <p>{{$title}}</p>
            <p>
    you have recieve this email because you have make a register to {{$website}} 
    
            </p>
<p>
    <a href="{{$link}}" target="_blank">Click here</a> to open link in 
the new tab or copy the link below  
</p>
            <p>{{$link}}</p>
    <p>your code : {{$code}}</p>
    <p>register on {{$registered_at}}</p>
<p>
    if this is not you please ignore this message.
</p>
        </div>
   </div>




@endsection
