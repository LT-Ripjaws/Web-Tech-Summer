<!DOCTYPE html>
<html>
<head>
    <title> Registration form</title>
</head> 
    <body>
        <center>
            <h1 style = "color: blue;"> AIUB Registration Form</h1>
            <h2 style = "color: green;"> Please Fill The Form</h2>
            <h4> Enter your information into the form</h4>
        </center>
        

        <style>
            body{background-color: lightblue;}
            table{border: 1px solid black; margin: auto; background-color: white; padding: 20px}
            
        </style>
        <form>
        <table>
            <tr>
                <td> Enter your name </td> <td> <input type = "text" ></td>
            </tr>
            <tr>
                <td> Enter your age </td> <td> <input type = "text" ></td>
            </tr>
            <tr>
                <td> Select your language </td> 
                <td> <input type = "radio" name = "des"> Bangla 
                 <input type = "radio" name = "des"> English 
                <input type = "radio" name = "des"> Hindi </td>
            </tr>
            <tr>
                <td> Select your area </td>
                <td> <input type = "checkbox" name = "des"> Dhaka 
                <input type = "checkbox" name = "des"> Barishal 
                 <input type = "checkbox" name = "des"> Chittagong 
            </td>
            </tr>
            <tr>
                <td> Country: </td>
                <td> <select name = "Country">
                    <option value = ""> --Select-- </option>
                    <option value = "Bangladesh"> Bangladesh </option>
                    <option value = "India"> India </option>
                    <option value = "USA"> USA </option>
                    <option value = "UK"> UK </option>
                </select>
            </td>
            </tr>
            <tr>
                <td> Upload the file </td> 
                <td> <input type = "file"> </td>
            </tr>
            <tr>
                <td> Comments: </td>
                <td> <textarea rows = "4" cols = "50" placeholder="Write your comments here"></textarea> </td>
            </tr>
        </table>

        <br>
        <center>
            <input type = "submit" value = "Submit">
            <input type = "reset" value = "Reset">
        </center>
        <br>
</form>
    </body>
</html>