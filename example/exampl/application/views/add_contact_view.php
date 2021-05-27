<html>
<head>
    <title>AddingNewContact</title>
</head>
<body>
<form name="test" method="post" action="/add_contact">
    <p><b>Name*:</b><br>
        <input type="text" name='name' size="40" required placeholder="Enter the name">
    </p>
    <p><b>Telephone number*:</b><br>
        <input type="text" name="tel" size="40" required placeholder="Enter the phone number">
    </p>
    <p><b>Address:</b><br>
        <input type="text" name="address" size="40" placeholder="Enter an address">
    </p>
    <p><b>Email:</b><br>
        <input type="text" name="email" size="40" placeholder="Enter an email">
    </p>
    <p><input type="submit" value="Add"></p>
    <p>Поля, обозначенные символом *, - обязательны для заполнения</p>
</form>
<a href="/main">Return to the main page</a>
</body>
</html>