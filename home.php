<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slot Registration</title>
    <style>
        body {
            margin: 50;
            padding: ;
            font-family: 'Cinzel Decorative', cursive;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 45%;
            overflow: hidden; /* Ensure overflow is hidden to prevent scrollbars */
            background-image: url('gmuu1.jpg');
                        
            background-size: cover;
            animation: slide 16s linear infinite; /* Adjusted duration for 0.5s interval per image */
        }

        @keyframes slide {
            0%, 100% {
                background-position: 0 0, 100% 0, 200% 0, 300% 0;
            }
            25% {
                background-position: 0 0, 0 100%, 100% 100%, 200% 100%;
            }
            50% {
                background-position: 0 0, 0 200%, 0 100%, 100% 100%;
            }
            75% {
                background-position: 0 0, 0 300%, 0 200%, 0 100%;
            }
        }

        h1 {
            text-align: center;
            font-size: 3em;
            padding: 5px 5px 5px 5px;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 5px;
            font-family: 'Cinzel Decorative', cursive;
            color: #ffcc00;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
        }

        a {
            display: inline-block;
            text-align: center;
            font-size: 0.4em;
            color: #ffcc00;
            text-decoration: none;
            margin-top: 200px;
            padding: 5px 5px;
            border: 3px solid #ffcc00;
            border-radius: 8px;
            background: rgba(0, 0, 0, 0.7);
            transition: all 0.5s ease;
            cursor: pointer;
            font-family: 'Cinzel Decorative', cursive;
            letter-spacing: 1px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        a:hover {
            background: #ffcc00;
            color: #000;
        }
    </style>
</head>

<body>
  <a href="login.php"><h1>Slot Registration</h1></a>
</body>

</html>
