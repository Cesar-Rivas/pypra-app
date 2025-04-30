const container = document.getElementById('viewer');

const scene = new THREE.Scene();
const camera = new THREE.PerspectiveCamera(45, 1, 0.1, 1000);
const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
renderer.setPixelRatio(window.devicePixelRatio);
container.appendChild(renderer.domElement);

// OrbitControls
const controls = new THREE.OrbitControls(camera, renderer.domElement);
controls.enableDamping = true;
controls.dampingFactor = 0.05;
controls.screenSpacePanning = false;
controls.minDistance = 1;
controls.maxDistance = 100;
controls.maxPolarAngle = Math.PI; // 🔥 Permitir rotación completa vertical

const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
directionalLight.position.set(5, 10, 7.5);
scene.add(directionalLight);

const ambientLight = new THREE.AmbientLight(0x404040, 2);
scene.add(ambientLight);

let model;
let loader = new THREE.GLTFLoader();
let targetDistance = 5;
let currentDistance = 10;
let autoRotate = true;
let animatingCamera = true;
let lastInteractionTime = Date.now();
const inactivityTimeout = 1500; // 1.5 segundos

function adjustViewerSize() {
    renderer.setSize(container.clientWidth, container.clientHeight);
    camera.aspect = container.clientWidth / container.clientHeight;
    camera.updateProjectionMatrix();
}

function adjustModelScaleAndCamera() {
    if (!model) return;

    const box = new THREE.Box3().setFromObject(model);
    const size = box.getSize(new THREE.Vector3());
    const maxDim = Math.max(size.x, size.y, size.z);

    const desiredSize = 2; // Queremos que mida máximo 2 unidades
    const scaleFactor = desiredSize / maxDim;
    model.scale.setScalar(scaleFactor);

    // Recalcular bounding box después de escalar
    const scaledBox = new THREE.Box3().setFromObject(model);
    const scaledSize = scaledBox.getSize(new THREE.Vector3());
    model.position.set(0, -(scaledSize.y / 2), 0); // 🔥 Centrado en Y

    const fov = camera.fov * (Math.PI / 180);
    let distance = (Math.max(scaledSize.x, scaledSize.y, scaledSize.z) / 2) / Math.tan(fov / 2);
    distance *= 1.2; // Márgen de aire

    targetDistance = distance;
    currentDistance = distance * 1.5;
    camera.position.set(0, 0, currentDistance);
    camera.lookAt(0, 0, 0);

    animatingCamera = true; // Activar animación de acercamiento inicial
}

function updateActiveButton(modelName) {
    const isMobile = window.innerWidth <= 768;

    if (isMobile) {
        const dropdown = document.getElementById('modelDropdown');
        if (dropdown) dropdown.value = modelName;
    } else {
        const buttons = document.querySelectorAll('#modelButtons button');
        buttons.forEach(button => {
            if (button.textContent === modelName) {
                button.classList.add('active');
            } else {
                button.classList.remove('active');
            }
        });
    }
}



function loadModel(name) {
    if (model) {
        scene.remove(model);
    }

    loader.load(`models/${name}.gltf`, function(gltf) {
        model = gltf.scene;
        scene.add(model);
        adjustViewerSize();
        adjustModelScaleAndCamera();
        updateActiveButton(name); // 🔥 Marcar el botón actual
    }, undefined, function(error) {
        console.error('Error cargando el modelo:', error);
    });
}

function generateModelButtons(models) {
    const isMobile = window.innerWidth <= 768; // Detectar móvil simple
    const container = document.getElementById('modelSelector');

    container.innerHTML = ''; // Limpiar contenido anterior

    if (isMobile) {
        // Crear dropdown
        const select = document.createElement('select');
        select.className = 'form-select';
        select.id = 'modelDropdown';

        const defaultOption = document.createElement('option');
        defaultOption.selected = true;
        defaultOption.disabled = true;
        defaultOption.textContent = 'Modelos 3D';
        select.appendChild(defaultOption);

        models.forEach(modelName => {
            const option = document.createElement('option');
            option.value = modelName;
            option.textContent = modelName;
            select.appendChild(option);
        });

        select.onchange = (e) => {
            if (e.target.value !== "Modelos 3D") {
                loadModel(e.target.value);
            }
        };

        container.appendChild(select);

    } else {
        // Crear btn-group-vertical
        const btnGroup = document.createElement('div');
        btnGroup.className = 'btn-group-vertical w-100';
        btnGroup.id = 'modelButtons';

        models.forEach(modelName => {
            const button = document.createElement('button');
            button.className = 'btn btn-outline-light mb-2';
            button.textContent = modelName;
            button.onclick = () => loadModel(modelName);
            btnGroup.appendChild(button);
        });

        container.appendChild(btnGroup);
    }
}



fetch('listModels.php')
    .then(response => response.json())
    .then(models => {
        generateModelButtons(models);
        if (models.length > 0) {
            loadModel(models[0]); // Cargar primer modelo automáticamente
        }
    })
    .catch(error => console.error('Error obteniendo modelos:', error));

// Detectar interacción
controls.addEventListener('start', () => {
    autoRotate = false;
    animatingCamera = false;
    lastInteractionTime = Date.now();
});

controls.addEventListener('change', () => {
    lastInteractionTime = Date.now();
});

function animate() {
    requestAnimationFrame(animate);

    if (model) {
        if (autoRotate) {
            model.rotation.y += 0.003;
        }

        if (animatingCamera) {
            if (Math.abs(camera.position.z - targetDistance) > 0.01) {
                camera.position.z += (targetDistance - camera.position.z) * 0.05;
            } else {
                camera.position.z = targetDistance;
                animatingCamera = false;
            }
        }
    }

    if (!autoRotate && Date.now() - lastInteractionTime > inactivityTimeout) {
        autoRotate = true;
    }

    controls.update();
    renderer.render(scene, camera);
}
animate();

window.addEventListener('resize', () => {
    adjustViewerSize();
    adjustModelScaleAndCamera();
});
