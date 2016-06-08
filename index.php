<html>
<head>
   <meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <style>
        input.b1 {
            font-weight: 400;
            color: white;
            text-decoration: none;
            padding: .8em 0.6em calc(.8em + 3px);
            border-radius: 3px;
            background: rgb(64,199,129);
            box-shadow: 0 -3px rgb(53,167,110) inset;
            transition: 0.2s;
            width:8%;
         
        } 
        a.button7:hover { background: rgb(53, 167, 110); }
        a.button7:active { background: rgb(33,147,90);box-shadow: 0 3px rgb(33,147,90) inset; }

        body {
            position: fixed;
			margin:0; 
			/*background: #FFFACD;*/
            background-image: url(gmg.png);
            background-size: 30%;
            background-repeat: no-repeat;
            background-position-x:  right;
            cursor: url(c.cur),pointer;
            
            
        }
        canvas{
            position: relative;
            width: 100%;
            margin: 0;
            
        }
        
        .dg {
			right: auto!important;
			left: 20px!important;
		}
     
    </style>
</head>
<body> 
		<script type="text/javascript" src="js/three.min.js"></script>
		<script type="text/javascript" src="js/OrbitControls.js"></script>
    <script type="text/javascript" src="js/dat.gui.min.js"></script>
        
		<script type="text/javascript">
           
            
            var container, stats, light, controls, scene, renderer;
            
			var scene = new THREE.Scene();

			var camera = new THREE.PerspectiveCamera(75, window.innerWidth/window.innerHeight, 0.5, 51000);

			var renderer = new THREE.WebGLRenderer({ alpha: true });
			renderer.setSize(window.innerWidth, window.innerHeight);
			document.body.appendChild(renderer.domElement);
            
            controls = new THREE.OrbitControls( camera );
            controls.addEventListener( 'change', render );

            light = new THREE.DirectionalLight( 0xffffff );
            light.position.set( -1, -1, -1 );
            scene.add( light );

            light = new THREE.AmbientLight( 0x444444 );
            scene.add( light );
            
			var loader = new THREE.JSONLoader();
            loader.load("pohryzchik18.json", modelToScene);
                
			var ambientLight = new THREE.AmbientLight(0x010101);
			scene.add(ambientLight);

			var light = new THREE.PointLight( 0xFFFFDD );
			light.position.set( -5, 5, 35 );
			scene.add( light );
        
            
            camera.position.set( 0.1, 1, 2);
            camera.lookAt( scene.position );
            
         
            
            var render = function () {
				requestAnimationFrame(render);
                
                obj.rotation.y += 0.01;
                
                renderer.render(scene, camera);
                
          };
              
            
             var  animated = function () {
				requestAnimationFrame(animated);

				obj.rotation.y += guiControls.rotationY; //0.008
				obj.rotation.x += guiControls.rotationX; //0.008
				obj.rotation.z += guiControls.rotationZ; //0.008

                renderer.render(scene, camera);
            };
           

			function modelToScene( geometry, materials ) {
				var material = new THREE.MeshFaceMaterial( materials );
				obj = new THREE.Mesh( geometry, material );
				obj.scale.set(0.2,0.2,0.2);                

				scene.add( obj );
			}
            
           
        //screen
            function toggleFullScreen() {
          if (!document.fullscreenElement &&    // alternative standard method
              !document.mozFullScreenElement && !document.webkitFullscreenElement) {  // current working methods
            if (document.documentElement.requestFullscreen) {
              document.documentElement.requestFullscreen();
            } else if (document.documentElement.mozRequestFullScreen) {
              document.documentElement.mozRequestFullScreen();
            } else if (document.documentElement.webkitRequestFullscreen) {
              document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
            }
          } else {
            if (document.cancelFullScreen) {
              document.cancelFullScreen();
            } else if (document.mozCancelFullScreen) {
              document.mozCancelFullScreen();
            } else if (document.webkitCancelFullScreen) {
              document.webkitCancelFullScreen();
            }
          }
        }
        //end full screen
            
            var obj1 = { Start_animated:function () {
				         animated();
                },
                         fullScreen:function(){
                         toggleFullScreen();
                }
            };
            
            var obj2 = { wireframe:function(){  
                wireframe = new THREE.WireframeHelper( obj, 0x00ff00 );
                scene.remove(obj);
                scene.add( wireframe );  
            }};
            
             var obj3 = { addMesh:function(){  
                scene.remove(obj);
                scene.remove(wireframe);
                loader.load("pohryzchik18.json", modelToScene);
            }};
            
            var guiControls = new function(){
                this.rotationX = 0.0;
                this.rotationY = 0.0;
                this.rotationZ = 0.0;
            }

            var datGUI = new dat.GUI();
                datGUI.add(obj1, 'Start_animated', 0, 1);
                datGUI.add(guiControls, 'rotationX', 0, 1);
                datGUI.add(guiControls, 'rotationY', 0, 1);
                datGUI.add(guiControls, 'rotationZ', 0, 1);
                datGUI.add(obj2,'wireframe', 0 ,1);
                datGUI.add(obj3,'addMesh', 0 ,1);
                datGUI.add(obj1,'fullScreen', 0 ,1);


            animated();
        </script>
        
    
       
     
      </body>