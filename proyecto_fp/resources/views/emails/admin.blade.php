<!Doctype html>
<html>
    <head>
        <style>
            
            body{
                display: flex;
                flex-direction: column;
                justify-content:  center;
                align-items: center;
                
            }
            h2{
                padding: 15px;
                background: #222;
                color:white;
                font-size: 2em;
                width: 100%;
                text-align: center;
                text-transform: uppercase;
                margin:0px; 
            }
            
            .cuerpo{
                background: #EEE;
                height: fit-content;
                width: 100%;
            }
            .cuerpo p{
                margin-top:50px;
                margin-bottom: 50px;
                margin-left: 25px;
            }
            footer{
                 padding: 15px;
                background: #222;
                color:white;
                                width: 100%;
                                text-align: right;  

            }
        </style>
    </head>
    <body>
        <h2>{{$title}}</h2>
        <div class="cuerpo">
            
            <p>{{$body}}</p>
        </div>
        
        <footer><h5>Adminstración de Seneca Lib</h5></footer>
    </body>
</html>