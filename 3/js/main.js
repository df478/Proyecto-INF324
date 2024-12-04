// Configuración de la escena, cámara y renderizador
const escena = new THREE.Scene();
const camara = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);

const renderizador = new THREE.WebGLRenderer();
renderizador.setSize(window.innerWidth, window.innerHeight);
document.body.appendChild(renderizador.domElement);

// Crear un material y geometría para el triángulo (un plano con 3 vértices)
const geometria = new THREE.BufferGeometry();
const vertices = new Float32Array([
    0.0,  1.0, 0.0,  // Vértice superior
   -1.0, -1.0, 0.0,  // Vértice inferior izquierdo
    1.0, -1.0, 0.0   // Vértice inferior derecho
]);

geometria.setAttribute('position', new THREE.BufferAttribute(vertices, 3));

const material = new THREE.MeshBasicMaterial({ color: 0xff0000, wireframe: true });

// Crear un mesh con la geometría y el material
const triángulo = new THREE.Mesh(geometria, material);
escena.add(triángulo);

// Colocar la cámara
camara.position.z = 5;

// Función de animación
function animar() {
    requestAnimationFrame(animar);

    // Rotar el triángulo
    //triángulo.rotation.x += 0.01;
    triángulo.rotation.y += 0.01;

    renderizador.render(escena, camara);
}

// Iniciar la animación
animar();

// Ajustar el tamaño del canvas cuando se redimensiona la ventana
window.addEventListener('resize', () => {
    camara.aspect = window.innerWidth / window.innerHeight;
    camara.updateProjectionMatrix();
    renderizador.setSize(window.innerWidth, window.innerHeight);
});
