//created by XORXOR, 2016

var renderer,scene,camera;
var camPosIndex = 0;
var lightPosIndex =0;
var spline;
var cube;
var light,light2;
var geometry;
var points = [];
var mirrorCamera;
var pitchObject;
var yawObject;
var viewHalfX = window.innerWidth / 2;
var viewHalfY = window.innerHeight / 2;


function init(){
  renderer = new THREE.WebGLRenderer();
  renderer.setClearColor(0x489eba);

  scene = new THREE.Scene();
  scene.fog = new THREE.FogExp2(0x489eba, .02);

  renderer.setSize(window.innerWidth, window.innerHeight);
  document.body.appendChild(renderer.domElement);

  // LIGHTS
  var ambient = new THREE.AmbientLight( 0x444444,2 );
  scene.add(ambient);

  light = new THREE.PointLight( 0xffffff,3,20 );
  light.decay = 1.7;
  scene.add(light);
  
  //
  camera = new THREE.PerspectiveCamera( 75, window.innerWidth / window.innerHeight, .1, 2000 );

  points.push(
    new THREE.Vector3(90.76810240262256,-78.43994701631564,-60.87430461522736),
    new THREE.Vector3(-33.1123,34.85931810950564,35.06127159348286),//
    new THREE.Vector3(79.22098098525535,-8.802698381849979,29.62917940815953),
    new THREE.Vector3(55.05579997071459,-16.593400565731244,-48.79556538193444),
    new THREE.Vector3(37.62036817620748,37.206369510919586,-19.950374022162435),
    new THREE.Vector3(-50.23172552629842,-72.95556733147235,75.26705781847252),
    new THREE.Vector3(-65.030251953891,78.99307182222435,53.45752143455286),
    new THREE.Vector3(34.8261286740923,89.51630321773513,-30.854391065746213),
    new THREE.Vector3(65.38132151720166,-25.380398187933068,23.56858681977046),
    new THREE.Vector3(23.5946652523393,-100.53186034944234,7.089341210401528)
    )
  spline = new THREE.CatmullRomCurve3(points);
  spline.closed = true;

  var extrudeSettings = {
    steps     : 1000,
    bevelEnabled  : false,
    extrudePath   : spline
  };
  
  //create shape for tunnel
  var pts = [], count = 16;
  for ( var i = 0; i < count; i ++ ) {
    var l = 5;
    var a = 2 * i / count * Math.PI;
    pts.push( new THREE.Vector2 ( Math.cos( a ) * l, Math.sin( a ) * l ) );
  }

  var shape = new THREE.Shape(pts);
  geometry = new THREE.ExtrudeGeometry( shape, extrudeSettings );  
  geometry.computeVertexNormals();

  mirrorCamera = new THREE.CubeCamera( 0.1, 50000, 2048 );
  scene.add( mirrorCamera );

  var materials = [
    new THREE.MeshPhongMaterial( { transparent: true, opacity: .6,specular: 0xd4dad6, shininess: 60, envMap: mirrorCamera.renderTarget.texture,  shading: THREE.FlatShading,fog:true }),
    new THREE.MeshBasicMaterial( { wireframe: false } ),
    new THREE.MeshBasicMaterial( { wireframe: true } )

  ];

  // assign material to each face
  for( var i = 0; i < geometry.faces.length; i++ ) {
      var r = Math.random();
      if (r>.1) {
        geometry.faces[i].materialIndex = 0;
      }
      if (r< .2) {
        geometry.faces[i].materialIndex = 2;
      }
      if (r< .1) {
        geometry.faces[i].materialIndex = 1;
      }
      
  }
 // flip normlas 
 for (var i = geometry.faces.length - 1; i >= 0; i--) {
        var face = geometry.faces[i];
        var temp = face.a;
        face.a = face.c;
        face.c = temp;
    }
  materials[0].side = THREE.DoubleSided;
  geometry.sortFacesByMaterialIndex();

  // mesh
  var mesh = new THREE.Mesh( geometry, new THREE.MeshFaceMaterial( materials ) );
  scene.add( mesh );


  //controls
  pitchObject = new THREE.Object3D();
  pitchObject.add(camera);

  yawObject = new THREE.Object3D();
  yawObject.position.y = 10;
  yawObject.add( pitchObject );

  scene.add(yawObject)
  
  document.addEventListener( 'mousemove', onMouseMove, false );
  window.addEventListener('resize', onWindowResize, false);

}

function onMouseMove( event ) {
    var movementX = event.pageX - viewHalfX; 
    var movementY = event.pageY - viewHalfY; 
    pitchObject.rotation.y = -movementX * 0.002;
    pitchObject.rotation.x = -movementY * 0.002;

    pitchObject.rotation.x = Math.max( - Math.PI / 2, Math.min( Math.PI / 2, pitchObject.rotation.x ) );
  };

function onWindowResize() {
  camera.left = window.innerWidth / - 2;
  camera.right = window.innerWidth / 2;
  camera.top = window.innerHeight / 2;
  camera.bottom = window.innerHeight / - 2;
  camera.updateProjectionMatrix();
  viewHalfX = window.innerWidth / 2;
  viewHalfY = window.innerHeight / 2;
  renderer.setSize( window.innerWidth, window.innerHeight );
}

function animate() {
  var time = performance.now() * 0.001;

  renderer.render(scene, camera);
  requestAnimationFrame(animate);
  
	camPosIndex +=0.2;
  if (camPosIndex > 1000) {
    camPosIndex = 0;
  }
  lightPosIndex += .22;
  if (lightPosIndex > camPosIndex+100) {
    lightPosIndex = camPosIndex-10;
  }

  var camPos = spline.getPoint(camPosIndex / 1000);
  var lightPos = spline.getPoint(lightPosIndex / 1000);
  var camRot = spline.getTangent(camPosIndex / 1000);
  
  yawObject.position.x = camPos.x;
  yawObject.position.y = camPos.y;
  yawObject.position.z = camPos.z;

  yawObject.lookAt(spline.getPoint((camPosIndex-1) / 1000))

  light.position.copy( yawObject.position );

  mirrorCamera.position = light.position;
  mirrorCamera.updateCubeMap( renderer, scene );

}

init();
animate();

