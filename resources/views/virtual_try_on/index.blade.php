{{-- resources/views/virtual_try_on/index.blade.php --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Try-On</title>
    <script src="https://aframe.io/releases/1.2.0/aframe.min.js"></script>
</head>
<body>
    <h1>Virtual Try-On</h1>
    
    <form action="/virtual-try-on/process" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="image">Upload your photo:</label><br>
        <input type="file" id="image" name="image" accept="image/*"><br><br>
        <button type="submit">Try On</button>
    </form>

    <a-scene embedded arjs>
        <!-- AR content (virtual glasses or contact lenses) will be rendered here -->
        @isset($virtualObjectPosition)
            <a-entity id="virtual-object" gltf-model="#virtual-object-model" position="{{ $virtualObjectPosition }}"></a-entity>
        @endisset
    
        <!-- Interactive controls for adjusting virtual object -->
        <a-camera-static>
            <a-cursor raycaster="objects: [mixin='virtual-object']" fuse="true"></a-cursor>
        </a-camera-static>
    </a-scene>
    

    



<script>
    document.addEventListener('DOMContentLoaded', function () {
        var scene = document.querySelector('a-scene');
        var virtualObject = document.querySelector('#virtual-object');

        if (virtualObject) {
            virtualObject.setAttribute('scale', '0.01 0.01 0.01');

            // Add event listeners for interaction
            virtualObject.addEventListener('click', function () {
                // Handle click event (e.g., toggle visibility, open details)
            });

            // Register cursor listener component for click events on the virtual object
            virtualObject.setAttribute('cursor-listener', {});
        }
    });

    // Cursor listener component to handle cursor events
    AFRAME.registerComponent('cursor-listener', {
        init: function () {
            var el = this.el;
            var isGrabbing = false;
            var previousPosition = { x: 0, y: 0, z: 0 };
            var previousRotation = { x: 0, y: 0, z: 0 };
            var previousScale = { x: 1, y: 1, z: 1 };

            el.addEventListener('click', function (evt) {
                // Handle cursor click event on virtual object
                isGrabbing = !isGrabbing; // Toggle grab state
                if (isGrabbing) {
                    previousPosition = el.object3D.position.clone(); // Save previous position
                    previousRotation = el.object3D.rotation.clone(); // Save previous rotation
                    previousScale = el.object3D.scale.clone(); // Save previous scale
                }
            });

            el.addEventListener('mousedown', function (evt) {
                if (isGrabbing) {
                    previousPosition = el.object3D.position.clone(); // Save previous position
                    previousRotation = el.object3D.rotation.clone(); // Save previous rotation
                    previousScale = el.object3D.scale.clone(); // Save previous scale
                }
            });

            el.addEventListener('mouseup', function (evt) {
                if (isGrabbing) {
                    previousPosition = el.object3D.position.clone(); // Save previous position
                    previousRotation = el.object3D.rotation.clone(); // Save previous rotation
                    previousScale = el.object3D.scale.clone(); // Save previous scale
                }
            });

            el.addEventListener('raycaster-intersected', function () {
                el.sceneEl.canvas.style.cursor = 'grab';
            });

            el.addEventListener('raycaster-intersected-cleared', function () {
                el.sceneEl.canvas.style.cursor = 'auto';
            });

            el.addEventListener('dragmove', function (evt) {
                if (isGrabbing) {
                    var deltaPosition = {
                        x: evt.detail.position.x - evt.detail.lastPosition.x,
                        y: evt.detail.position.y - evt.detail.lastPosition.y,
                        z: evt.detail.position.z - evt.detail.lastPosition.z
                    };

                    el.object3D.position.add(deltaPosition);
                }
            });

            el.addEventListener('gripdown', function (evt) {
                if (isGrabbing) {
                    previousRotation = el.object3D.rotation.clone(); // Save previous rotation
                }
            });

            el.addEventListener('gripup', function (evt) {
                if (isGrabbing) {
                    previousRotation = el.object3D.rotation.clone(); // Save previous rotation
                }
            });

            el.addEventListener('scalechange', function (evt) {
                if (isGrabbing) {
                    previousScale = el.object3D.scale.clone(); // Save previous scale
                }
            });
        }
    });
</script>
</body>
</html>
