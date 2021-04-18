<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_top.php');
?>
<title>login</title>
</head>

<body>

    <form action="/login" method="POST" onsubmit="return validate()">

        <h1>Login</h1>

        <label for="email">Email</label>
        <input type="text" placeholder="Email" data-validate="email" name="email">
        <label for="pass">Password</label>
        <input type="password" placeholder="Password" data-validate="pass" name="pass">
        <button>Login</button>
        <div>
            <p>Don't have an account? <a href="/signup">Sign-up</a></p>
        </div>

    </form>
    <script src="../js/validator.js"></script>
</body>

</html>