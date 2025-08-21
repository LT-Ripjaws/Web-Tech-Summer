<!DOCTYPE html>
<html>
<head>
    <title> Customer Registration form</title>
</head>
    <style>
        body {background-color: lightblue;}

        table {background-color: skyblue;
               border: 1px solid black;
               margin: auto;
               padding: 10px;}
        h1 {color: darkblue;}
        h2, h3 {color: darkgreen;} 

        input[type="submit"], input[type="reset"]
        {
        cursor: pointer;
        padding: 5px;
        background-color: lightgray;
        position: relative;
        left: 250px;
        }

        input[type="text"]
        {
            font-family: 'Times New Roman', Times, serif
        }
    
    </style>

<body>
    <center>
        <img src="https://static.vecteezy.com/system/resources/previews/013/948/616/non_2x/bank-icon-logo-design-vector.jpg" width="100" height="100">
        <h1> Bank Management System</h1>
        <h2> Your Trusted Financial Partner</h2>
        <h3> Customer Registration Form</h3>
    </center>
    <form>
        <table>
            <tr>
                <td> Full Name: </td>
                <td> <input type="text"> </td>
            </tr>

            <tr>
                <td> Date of Birth: </td>
                <td> <input type="date"> </td>
            </tr>

            <tr>
                <td> Gender: </td>
                <td>
                    <input type="radio" name="des"> Male
                    <input type="radio" name="des"> Female
                    <input type="radio" name="des"> Other
                </td>
            </tr>

            <tr>
                <td> Marital Status: </td>
                <td> <select name="Marital_status">
                    <option value="">--Select--</option>
                    <option value="single">Single</option>
                    <option value="married">Married</option>
                    <option value="divorced">Divorced</option>
                    </select>
                </td>
            </tr>


            <tr>
                <td> Account type: </td>
                <td> <select name="Account_type">
                    <option value="">--Select--</option>
                    <option value="savings">Savings</option>
                    <option value="current">Current</option>
                    <option value="fixed">Fixed Deposit</option>
                    <option value="joint">Joint Account</option>
                </select>
            </tr>

            <tr>
                <td> Initial Deposite Amount: </td>
                <td> <input type="number"> </td>
            </tr>
            <tr>
                <td> Mobile Number: </td>
                <td> <input type="number"> </td>
            </tr>

            <tr>
                <td> Email Address </td>
                <td> <input type="email"> </td>
            </tr>

            <tr>
                <td> Address: </td>
                <td> <textarea rows="4" cols="50" placeholder="Enter your address"></textarea> </td>
            </tr>

            <tr>
                <td> Occupation: </td>
                <td> <input type="text"> </td>
            </tr>

            <tr>
                <td> National ID (NID): </td>
                <td> <input type="number"> </td>
            </tr>

            <tr>
                <td> Set Password: </td>
                <td> <input type="password"> </td>
            </tr>

            <tr> 
                <td> Upload ID Proof: </td>
                <td> <input type="file"> </td>
            </tr>

            <tr>
                <td> <input type="checkbox"> i agree to the terms and conditions </td>
            </tr>

            <tr>
                <td> <input type="submit" value="Register">
                     <input type="reset" value="Reset"> 
                </td>
            </tr>
        </table>
    </form>
</body>
</html>