
                function draw() {  
                    var objects = document.getElementsByClassName('goldjob');
                    for (var i = 0; i < objects.length; i++){
                        var canvas = objects[i];
                        if (canvas.getContext){
                          var ctx = canvas.getContext('2d');
                          ctx.fillStyle = "#fafafa";
                          ctx.beginPath();
                          ctx.moveTo(0,0);
                          ctx.lineTo(10,10);
                          ctx.lineTo(0,20);
                          ctx.fill();
                        }
                    }
                    var objects = document.getElementsByClassName('newjob');
                    for (var i = 0; i < objects.length; i++){
                        var canvas = objects[i];
                        if (canvas.getContext){
                          var ctx = canvas.getContext('2d');
                          ctx.fillStyle = "#fafafa";
                          ctx.beginPath();
                          ctx.moveTo(0,0);
                          ctx.lineTo(10,10);
                          ctx.lineTo(0,20);
                          ctx.fill();
                        }
                    }
                    var objects = document.getElementsByClassName('featuredjob');
                    for (var i = 0; i < objects.length; i++){
                        var canvas = objects[i];
                        if (canvas.getContext){
                          var ctx = canvas.getContext('2d');
                          ctx.fillStyle = "#fafafa";
                          ctx.beginPath();
                          ctx.moveTo(0,0);
                          ctx.lineTo(10,10);
                          ctx.lineTo(0,20);
                          ctx.fill();
                        }
                    }
                }
                window.onload = function(){
                    draw();
                }