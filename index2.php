<html>
<head>
<title>example 27: dat-gui</title>
<script type="text/javascript" src="js/three.js"></script>
<script type="text/javascript" src="js/three/stats.js"></script>
<script type="text/javascript" src="js/SpriteParticleSystem.js"></script>
<script type="text/javascript" src="js/dat.gui.min.js"></script>
<script type="text/javascript">

var controller = {
    psys:null,
    cloud:new THREE.Object3D(),
    rate:8,
    num:50,
    texture:null,
    scaleR:[.1,4],
    speedR:[0,0.5],
    rspeedR:[-0.1,0.3],
    lifespanR:[3,4],
    terminalSpeed:20,
    scene:null,
    scale_min:0.1,
    scale_max:4,
    speed_min:0,
    speed_max:0.5,
    rspeed_min:-0.1,
    rspeed_max:0.3,
    lifespan_min:3,
    lifespan_max:4,
    reset : function() {
        console.log("in controller.reset");
        if (controller.psys) {
            controller.scene.remove(controller.cloud);
            controller.cloud = new THREE.Object3D();
            controller.scene.add(controller.cloud);
        }
        controller.psys = new SpriteParticleSystem({
            cloud:controller.cloud,
            rate:controller.rate,
            num:controller.num,
            texture:controller.texture,
            scaleR:[controller.scale_min,controller.scale_max],
            speedR:[controller.speed_min,controller.speed_max],
            rspeedR:[controller.rspeed_min,controller.rspeed_max],
            lifespanR:[controller.lifespan_min,controller.lifespan_max],
            terminalSpeed:controller.terminalSpeed
        });
        controller.psys.start();
    },
    init : function(tex, scene, gui) {
        controller.scene = scene;
        controller.texture = tex;
        scene.add(controller.cloud);
        scene.add(controller.psys);
        gui.add(controller, 'reset');
        gui.add(controller, 'rate').min(0);
        gui.add(controller, 'num').min(1).step(1);
        gui.add(controller, 'scale_min').min(0);
        gui.add(controller, 'scale_max').min(0);
        gui.add(controller, 'speed_min').min(0);
        gui.add(controller, 'speed_max').min(0);
        gui.add(controller, 'rspeed_min',-10,10);
        gui.add(controller, 'rspeed_max',-10,10);
        gui.add(controller, 'lifespan_min').min(0);
        gui.add(controller, 'lifespan_max').min(0);
        gui.add(controller, 'terminalSpeed').min(0);
    },
    update : function(dt) {
        controller.psys.update(dt);
    }
};


function init() {
    var mycanvas = document.getElementsByTagName("canvas")[0];
    var w = mycanvas.clientWidth;
    var h = mycanvas.clientHeight;

    var scene = new THREE.Scene();

    var camera = new THREE.PerspectiveCamera( 60, w/h, 1, 10000 );
    camera.position.z = 1500;
    scene.add(camera);
    
    var psys;
    var gui = new dat.GUI();
    THREE.ImageUtils.loadTexture( "images/smoke.png", undefined, onTexLoad );
    function onTexLoad(tex) {
        console.log(tex,scene,gui);
        controller.init(tex, scene, gui);
    }

    var renderer = new THREE.WebGLRenderer({canvas:mycanvas});
    renderer.setSize( w, h );
    renderer.setClearColor( 0x000000, 1 );

    var stats = new Stats();
    stats.domElement.style.position = 'absolute';
    stats.domElement.style.top = '0px';
    stats.domElement.style.zIndex = 100;
    var container = document.getElementById("container");
    container.appendChild( stats.domElement );
    
    var clock = new THREE.Clock();

    function animate() {
        var dt = clock.getDelta();
        if (controller.psys) {
            controller.update(dt);
            controller.psys.position.x = 100 * Math.sin( clock.getElapsedTime() );
            controller.psys.position.y = 100 * Math.sin( clock.getElapsedTime() );
        }
        renderer.render( scene, camera );
        stats.update();
        requestAnimationFrame( animate );
    }

    animate();
}

window.onload = init;
</script>
<style> 
    body{
        margin: 0 ;
    }    
</style>
</head>
<body>
<div id="container"><canvas style="width:100%;height:95%;border:1px gray solid;"></div>
</body>
</html>    