<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Email Notification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body>
<h2>
    Hello {{ $letter->user->email }}
</h2>

<h3>
    Your letter has been read
</h3>

<p>
    <b>Recipient:</b> {{$letter->recipient}}  </br>
    <b>Subject letter:</b>  {{$letter->subject_letter}} </br>
    <b>Departure date:</b> {{$letter->created_at}} </br>
    <b>Date read:</b> {{$letter->last_open}} </br>
</p>

<h3>
    Have a good day!
</h3>

</body>
</html>
