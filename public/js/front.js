var init_controls = true;

var hue = 0.1;
var color_var = new THREE.Color( 0x000000 );
var mixer = null;

var wheel;

var body;
var wheel_A;
var wheel_B;

var container = jQuery("#canvas_3d");

var modelsrn = [];
var models_added = [];

var clock = new THREE.Clock();
var scene = new THREE.Scene();
const camera = new THREE.PerspectiveCamera( 75, container.innerWidth() / container.innerHeight(), 0.1, 1000 );

let camPositionSpan, camLookAtSpan;

const center_group = new THREE.Group();
scene.add(center_group)

if(has_light) {
    const light = new THREE.AmbientLight( 0x888888);
    scene.add( light );
}
if(has_shadow) {
    const light_shadow = new THREE.PointLight( 0xFFFFFF, 1.4, 100 );
    light_shadow.position.set( 1, 4, 1 );
    light_shadow.castShadow = true;
    //Set up shadow properties for the light
    light_shadow.shadow.mapSize.width = 512; // default
    light_shadow.shadow.mapSize.height = 512; // default
    light_shadow.shadow.camera.near = 0.5; // default
    light_shadow.shadow.camera.far = 500;
    scene.add( light_shadow );
}


/* camera.position.x = 0.0*magnify;
camera.position.y = 0.2*magnify;
camera.position.z = 1*magnify; */

camera.position.x = camera_x;
camera.position.y = camera_y;
camera.position.z = camera_z;

camera.position.setLength(7);
//camera.scale.x = camera.scale.y = camera.scale.z = 0.1;
const initialCameraPosition = camera.position.clone();
const initialCameraRotation = camera.rotation.clone();


const renderer = new THREE.WebGLRenderer({
    antialias: true,
    alpha: true,
    //preserveDrawingBuffer: true
});

/* renderer.shadowMap.enabled = true;
renderer.shadowMap.type = THREE.PCFSoftShadowMap; */

//renderer.toneMapping = THREE.ACESFilmicToneMapping;
renderer.outputEncoding = THREE.sRGBEncoding;




renderer.setPixelRatio( container.innerWidth() / container.innerHeight() );
//renderer.setPixelRatio( 1 );
const controls = new THREE.OrbitControls( camera, renderer.domElement );

controls.addEventListener( 'change', animate );

/* controls.minPolarAngle = 0;
controls.maxPolarAngle =  Math.PI * 0.48;
controls.minAzimuthAngle = 0;
controls.maxAzimuthAngle =  Math.PI * 0.48;
controls.maxDistance = 1.2*magnify;
controls.minDistance = 0.3/magnify;
controls.maxZoom = 1.2*magnify;
controls.minZoom = 0.3/magnify; */

controls.minPolarAngle = minPolarAngle * Math.PI / 180;
controls.maxPolarAngle =  maxPolarAngle * Math.PI / 180;
controls.minAzimuthAngle = minAzimuthAngle * Math.PI / 180;
controls.maxAzimuthAngle =  maxAzimuthAngle * Math.PI / 180;

if (maxZoom > 0) controls.maxDistance = maxZoom;
if (minZoom > 0) controls.minDistance = minZoom;
if (maxZoom > 0) controls.maxZoom = maxZoom;
if (minZoom > 0) controls.minZoom = minZoom;

controls.screenSpacePanning = false;

//controls.enableDamping = true;

function addObjectToGroup(object, group) {
    group.add(object);
    normalizeAndCenterGroup(group);
}

function normalizeAndCenterGroup(group) {

    group.scale.set(1, 1, 1);
    group.position.set(0, 0, 0);
    // Calculate the bounding box of the group
    const boundingBox = new THREE.Box3().setFromObject(group);
    const size = new THREE.Vector3();
    boundingBox.getSize(size);

    // Determine the maximum dimension and scale factor
    const maxDim = Math.max(size.x, size.y, size.z);
    const referenceSize = 7; // You can adjust this reference size as needed
    const scale = referenceSize / maxDim;
    // Apply the scale to the group
    group.scale.set(scale, scale, scale);
    // Update the bounding box after scaling
    boundingBox.setFromObject(group);
    const center = new THREE.Vector3();
    boundingBox.getCenter(center);
    // Adjust the group's position based on the new center
    group.position.set(-center.x, -center.y, -center.z);
}


init();
const resetButton = document.querySelector('#resetAxis');
resetButton.addEventListener('click', () => {
    console.log('resetting camera');

    // Disable controls temporarily
    controls.enabled = false;

    // Reset camera position and rotation
    camera.position.copy(initialCameraPosition);
    camera.rotation.copy(initialCameraRotation);

    // Reset the camera's up vector
    camera.up.set(0, 1, 0);

    // Update the camera's matrix
    camera.updateMatrix();
    camera.updateMatrixWorld();

    // If you're using OrbitControls, reset its target
    controls.target.set(0, 0, 0);
    controls.update();

    // Re-enable controls
    controls.enabled = true;

    // Force a re-render
    renderer.render(scene, camera);
});
function animate() {}

function init() {

    camPositionSpan = document.querySelector("#position");
    camLookAtSpan = document.querySelector("#lookingAt");

    //scene.background = new THREE.Color( 0xffffff );
    //scene.add(new THREE.AxesHelper(5));
    renderer.setSize( container.innerWidth(), container.innerHeight() );
    renderer.domElement.id = 'visor_3d';
    renderer.autoClear = false;
    renderer.setClearColor(0x00ff00, 0.0);
    container.get(0).appendChild( renderer.domElement );


   // const light = new THREE.AmbientLight( 0x202020 ); // soft white light
   // scene.add( light );

    // var loader = new THREE.TextureLoader();
    // var backgroundTexture = loader.load( 'https://i.imgur.com/upWSJlY.jpg' );


    var skyColor = 0xB1E1FF; // light blue
    var groundColor = 0xB97A20; // brownish orange
    var intensity = 0.6;
    /* var light = new THREE.HemisphereLight(skyColor, groundColor, intensity);
    scene.add(light); */

    //scene.background = backgroundTexture;

    /* var light2 = new THREE.AmbientLight( 0x888888 ); // soft white light
    scene.add( light2 );

    const light = new THREE.PointLight( 0xFFFFFF, 1.4, 100 );
    light.position.set( 1, 4, 1 );
    light.castShadow = true;
    //Set up shadow properties for the light
    light.shadow.mapSize.width = 512; // default
    light.shadow.mapSize.height = 512; // default
    light.shadow.camera.near = 0.5; // default
    light.shadow.camera.far = 500;
    scene.add( light ); */

    /* const directionalLight = new THREE.DirectionalLight( 0xffffff, 1 );
    scene.add( directionalLight ); */
    //var envmap = new THREE.TextureLoader().load( relative_path + '/public/models/test/background.hdr' );
    //var envmap = new THREE.RGBELoader().load( relative_path + '/public/models/test/background.hdr' );
    //scene.environment = envmap;
    //scene.background = envmap;
    controls.enableDamping = false;

    //var loader = new THREE.TextureLoader();
    //var texture = loader.load( 'https://i.imgur.com/upWSJlY.jpg' );

    // var hdr = new THREE.RGBELoader().load(relative_path + '/public/models/test/background.hdr', texture => {
    //     const gen = new THREE.PMREMGenerator(renderer);
    //     const envMap = gen.fromEquirectangular(texture).texture;
    //     scene.environment = envMap;
    //     scene.background = envMap;
    //
    //     texture.dispose();
    //     gen.dispose();
    //   });
    //scene.add(hdr);

    for (let i = 0; i < init_items.length; i ++) {
        let model = init_items[i][0];
        let model_color = init_items[i][1];
        add_model_gltf(relative_path + model, center_group, model_color);
    }

    // scene.add(new THREE.AxesHelper(5));

    animate();
}


function add_model_gltf(model_file, model_group, model_color, model_id = null) {
    const loader = new THREE.GLTFLoader();

    var dracoLoader = new THREE.DRACOLoader();
    dracoLoader.setDecoderPath( '/js/draco/gltf/' );
    loader.setDRACOLoader( dracoLoader );

    const material = null;

    loader.load( model_file, (gltf) => {
        if (model_color !== "") { colorize_model(gltf.scene, model_color); }
        gltf.scene.castShadow = true;
        gltf.scene.receiveShadow = true;

        if(model_id == null) {
            // base part
            addObjectToGroup(gltf.scene, center_group);
        } else {
            if (!gltf.scene.name) gltf.scene.name = model_id;
            //console.log('el model id para la base', model_id)
            // try clone
            const cloneGLTF = gltf.scene.clone();
            cloneGLTF.name = model_id;
            addObjectToGroup(cloneGLTF, center_group);
        }

        if (model_group !== 'base') {
            remove_model_group(model_group);
            if (!modelsrn[model_group]) modelsrn[model_group] = [];
            modelsrn[model_group].push(gltf.scene);
            models_added.push(model_id); // new line to handle infinite tree models
        }
    });

    animate = function() {
        requestAnimationFrame( animate );
        if (camPositionSpan) camPositionSpan.innerHTML = `Position: (${camera.position.x.toFixed(1)}, ${camera.position.y.toFixed(1)}, ${camera.position.z.toFixed(1)})`
        renderer.render( scene, camera );
    };


}


function add_model(model_file, model_group, model_color, model_id = null) {
    const material = new THREE.MeshBasicMaterial({ color: 0x00ff00, wireframe: true });
    if (model_file.endsWith('.obj')) {
        init_controls = false;
        var loader = new THREE.OBJLoader();
        loader.load(model_file, (object) => {
                 (object.children[0]).material = material
                 object.traverse(function (child) {
                     if ((child).isMesh) {
                         (child).material = material
                     }
                 })

                if (!object.name) object.name = object.uuid;
                //object.name = object.uuid;

                if (model_color != "") {
                    colorize_model(object, model_color);
                }

                scene.add(object);


                if (model_group != 'base') {
                    remove_model_group(model_group);
                    if (!modelsrn[model_group]) modelsrn[model_group] = [];
                    console.log("added rn to "+ model_group +": ");
                    console.log(object);
                    modelsrn[model_group].push(object);
                }
            },
            (xhr) => {
                //console.log((xhr.loaded / xhr.total) * 100 + '% loaded')
            },
            (error) => {
                console.log(error)
            }
        )

    } else if (model_file.endsWith('.hdr')) {
        new THREE.RGBELoader().load(model_file, texture => {
            const gen = new THREE.PMREMGenerator(renderer);
            const envMap = gen.fromEquirectangular(texture).texture;
            scene.environment = envMap;
            scene.background = envMap;

            texture.dispose();
            gen.dispose();
          });


    } else if (model_file.endsWith('.fbx')) {


        var skyColor = 0xB1E1FF; // light blue
        var groundColor = 0xB97A20; // brownish orange
        var intensity = 1;
        var light = new THREE.HemisphereLight(skyColor, groundColor, intensity);
        scene.add(light);

        var light2 = new THREE.AmbientLight( 0x404040 ); // soft white light
        scene.add( light2 );



        const loader = new THREE.FBXLoader();

        loader.load( model_file, (gltf) => {


            console.log(model_file);
            console.log(gltf);
            console.log(gltf.animations);
            console.log(gltf.scene);
            //console.log(md);

            //gltf.scale.set(0.1,0.1,0.1);
            if (model_color != "") {
                colorize_model(gltf, model_color);
            }

            gltf.castShadow = true;
            gltf.receiveShadow = true;
            scene.add( gltf );

            if (!gltf.name) gltf.name = gltf.uuid;

            if (model_group != 'base') {
                remove_model_group(model_group);
                if (!modelsrn[model_group]) modelsrn[model_group] = [];
                modelsrn[model_group].push(gltf);
            }
            //scene.add( md );
            console.log("DONE");

        },
        (xhr) => {
            console.log((xhr.loaded / xhr.total) * 100 + '% loaded')
        },
        (error) => {
            console.log(error)
        });


    } else {
        // this case is the only one which is clone the object before add it to the scene !!!

        const loader = new THREE.GLTFLoader();

        var dracoLoader = new THREE.DRACOLoader();
        dracoLoader.setDecoderPath( '/js/draco/gltf/' );
        loader.setDRACOLoader( dracoLoader );

        const material = null;
        //const material = new THREE.MeshBasicMaterial({ color: 0x00ff00, wireframe: true });
        //const material = new THREE.MeshPhongMaterial( { specular: 0x122222,shininess: 10,map: texture} );

        loader.load( model_file, (gltf) => {
            if (model_color !== "") { colorize_model(gltf.scene, model_color); }
            gltf.scene.castShadow = true;
            gltf.scene.receiveShadow = true;

            // scene.add( gltf.scene );
            if (!gltf.scene.name) gltf.scene.name = model_id;
            // try clone
            const cloneGLTF = gltf.scene.clone();
            cloneGLTF.name = model_id;
            scene.add(cloneGLTF);

            if (model_group !== 'base') {
                remove_model_group(model_group);
                if (!modelsrn[model_group]) modelsrn[model_group] = [];
                modelsrn[model_group].push(gltf.scene);
                models_added.push(model_id); // new line to handle infinite tree models
            }

        });


        // LA BONA
        animate = function() {
            requestAnimationFrame( animate );
            if (camPositionSpan) camPositionSpan.innerHTML = `Position: (${camera.position.x.toFixed(1)}, ${camera.position.y.toFixed(1)}, ${camera.position.z.toFixed(1)})`
            //color_var.setHSL(hue, 1, 0.6);
            /* hue = hue+0.005;
            if (hue >= 1) {
                hue = 0;
                wheel_A.visible = !wheel_A.visible;
                wheel_B.visible = !wheel_B.visible;
            }
            color_var.setHSL(hue, 1, 0.6);

            controls.update();
            var delta = clock.getDelta();
            if (mixer !== null) {
                mixer.update(delta);
            }; */

            renderer.render( scene, camera );

        };
    }

}


function colorize_model(model, color) {
    if (!model.children) return;

    var color_obj = new THREE.Color( "#" + color );

    for (let i = 0; i < model.children.length; i++) {
        let part = model.children[i];
        if (part.material) {
            //console.log("color to " + part.name);
            part.material.color = color_obj;
        }
        if (part.children) {
            colorize_model(part, color);
        }
    }
}


function set_material(part, material, name) {

    if (part.isMesh) {
        console.log(part.name, part.material);
        if (part.material.name == name) {
            if (material != null) part.material = material;
            part.material.color = color_var;
        }
    }

    if (part.children.length > 0) {
        for (var i = 0; i < part.children.length; i++) {
            //part.children[i].material = material;
            set_material(part.children[i], material, name);
        }
    }
}





function remove_model_group(model_group) {
    for (var group in modelsrn) {
        if (group == model_group) {
            let models = modelsrn[group];
            for (var key in models) {
                let model = models[key];
               // console.log("delete: " + model.name + " from group: " + model_group);
                //scene.remove(scene.getObjectByName(model.name));
                scene.remove(model);
                delete modelsrn[group][key];
            }
            delete modelsrn[group];
        }
    }
}

/**
 * Removing 3D models from the scene
 */
function clean_scene_from_old_models() {
    for(let element of models_added) {
        const objectToRemove = scene.getObjectByName(element)
        if(objectToRemove !== undefined) {
            scene.remove(objectToRemove)
            center_group.remove(objectToRemove)
        }
    }
    models_added = [] // clean old models, variable parts
}

// /**
//  * Add a collection of 3D models to the scene, glb/gltf format
//  * @param models_collection
//  */
// const add_group_model_gltf = (models_collection) => {
//     const loader = new THREE.GLTFLoader();
//     const dracoLoader = new THREE.DRACOLoader();
//     dracoLoader.setDecoderPath( '/js/draco/gltf/' );
//     loader.setDRACOLoader( dracoLoader );
//
//     for(let i = 0; i < models_collection.length; i++ ) {
//         loader.load( relative_path + models_collection[i].url, (gltf) => {
//             if (models_collection[i].color !== "") { colorize_model(gltf.scene, models_collection[i].color); }
//             gltf.scene.castShadow = true;
//             gltf.scene.receiveShadow = true;
//             // scene.add( gltf.scene );
//             if (!gltf.scene.name) gltf.scene.name = models_collection[i].id;
//             if (models_collection[i].group !== 'base') {
//                 remove_model_group(models_collection[i].group);
//                 if (!modelsrn[models_collection[i].group]) modelsrn[models_collection[i].group] = [];
//                 modelsrn[models_collection[i].group].push(gltf.scene);
//             }
//             // clone model
//             const cloneGLTF = gltf.scene.clone();
//             cloneGLTF.name = models_collection[i].id;
//             scene.add(cloneGLTF);
//             models_added.push(models_collection[i].url);
//         });
//     }
//     animate_group_model()
// }

// /**
//  *
//  */
// const animate_group_model = () => {
//     requestAnimationFrame( animate );
//     if (camPositionSpan) camPositionSpan.innerHTML = `Position: (${camera.position.x.toFixed(1)}, ${camera.position.y.toFixed(1)}, ${camera.position.z.toFixed(1)})`
//     renderer.render( scene, camera );
// }



/* function add_fbx(model_file) {
    const loader = new THREE.FBXLoader();


    var skyColor = 0xB1E1FF; // light blue
    var groundColor = 0xB97A20; // brownish orange
    var intensity = 1;
    var light = new THREE.HemisphereLight(skyColor, groundColor, intensity);
    scene.add(light);

    var light2 = new THREE.AmbientLight( 0x404040 ); // soft white light
    scene.add( light2 );


    controls.enableDamping = true;
    //renderer.outputEncoding = THREE.sRGBEncoding;

    loader.load( model_file, (gltf) => {
        console.log(gltf);
        console.log(gltf.animations);
        console.log(gltf.scene);

        scene.add( gltf );

        console.log("DONE");

    },
    (xhr) => {
        console.log((xhr.loaded / xhr.total) * 100 + '% loaded')
    },
    (error) => {
        console.log(error)
    });



    animate = function() {
        requestAnimationFrame( animate );
        controls.update();
        renderer.render( scene, camera );

    };
} */



/* function add_ferrari(model_file) {
    var loader = new THREE.GLTFLoader();

    const textureLoader = new THREE.TextureLoader();
    const texture =  textureLoader.load( '/images/marc.png', function(tex) {
        console.log("TEXTURE LOADED", tex);
        texture.anisotropy = 16;
        texture.wrapS = THREE.RepeatWrapping;
        texture.wrapT = THREE.RepeatWrapping;
        texture.repeat.set( 4, 4 );
    });


    var dracoLoader = new THREE.DRACOLoader();
    dracoLoader.setDecoderPath( '/js/draco/gltf/' );
    loader.setDRACOLoader( dracoLoader );


    const material = null;
    //const material = new THREE.MeshBasicMaterial({ color: 0x00ff00, wireframe: true });
    //const material = new THREE.MeshPhongMaterial( { specular: 0x122222,shininess: 10,map: texture} );


    var skyColor = 0xB1E1FF; // light blue
    var groundColor = 0xB97A20; // brownish orange
    var intensity = 1;
    var light = new THREE.HemisphereLight(skyColor, groundColor, intensity);
    scene.add(light);

    var light2 = new THREE.AmbientLight( 0x404040 ); // soft white light
    scene.add( light2 );


    controls.enableDamping = true;
    //renderer.outputEncoding = THREE.sRGBEncoding;

    //loader.load( 'models/homer/scene.gltf', function ( gltf ) {
    loader.load( model_file, (gltf) => {

        const md = gltf.scene.children[0];
        md.position.set(0, 0, 0);


        console.log(gltf);
        console.log(gltf.animations);
        console.log(gltf.scene);
        console.log(md);

        let part = md.getObjectByName( 'body' );
        if (material != null) part.material = material;
        else part.material.color = color_var;
        console.log(part.material);

        wheel = md.getObjectByName( 'wheel_fl' );

        scene.add( md );
        console.log("DONE");

    },
    (xhr) => {
        console.log((xhr.loaded / xhr.total) * 100 + '% loaded')
    },
    (error) => {
        console.log(error)
    });




    animate = function() {
        hue = hue+0.005;
        if (hue >= 1) {
            hue = 0;
            wheel.visible = !wheel.visible;

        }
        color_var.setHSL(hue, 1, 0.6);

        requestAnimationFrame( animate );
        controls.update();
        renderer.render( scene, camera );

    };
} */
