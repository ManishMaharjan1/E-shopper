<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
</head>
<body>
    <table>
        <thead>
            <tr><td>Dear {{$name}}!</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>You Account Has Been Successfully Activated.<br>
            Your account information is below</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>{{ $email }}</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>{{ $name }}</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Password:***** (as choosen by you)</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Thanks & Regards,</td></tr>
            <tr><td>E-Shoppe</td></tr>
        </thead>
    </table>
</body>
</html>