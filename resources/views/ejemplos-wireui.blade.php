{{-- 
    EJEMPLOS DE USO DE COMPONENTES WIREUI
    Con prefijo configurado como "wire-" en config/wireui.php
--}}

<div class="p-6 space-y-6">
    <h2 class="text-2xl font-bold mb-4">Ejemplos de Componentes WireUI</h2>

    {{-- ============================================ --}}
    {{-- 1. INPUT - Campo de texto básico --}}
    {{-- ============================================ --}}
    <div class="bg-white p-4 rounded shadow">
        <h3 class="font-bold mb-2">1. Input Básico</h3>
        <wire-input 
            wire:model="nombre" 
            label="Nombre"
            placeholder="Ingrese su nombre"
        />
    </div>

    {{-- Input con tipo email --}}
    <div class="bg-white p-4 rounded shadow">
        <h3 class="font-bold mb-2">Input Email</h3>
        <wire-input 
            type="email"
            wire:model="email" 
            label="Correo Electrónico"
            placeholder="correo@example.com"
        />
    </div>

    {{-- Input con tipo password --}}
    <div class="bg-white p-4 rounded shadow">
        <h3 class="font-bold mb-2">Input Password</h3>
        <wire-input 
            type="password"
            wire:model="password" 
            label="Contraseña"
            placeholder="Mínimo 8 caracteres"
        />
    </div>

    {{-- ============================================ --}}
    {{-- 2. SELECT NATIVO - Lista desplegable nativa --}}
    {{-- ============================================ --}}
    <div class="bg-white p-4 rounded shadow">
        <h3 class="font-bold mb-2">2. Select Nativo (Native Select)</h3>
        <wire-native-select 
            wire:model="estado"
            label="Estado"
            placeholder="Seleccione un estado"
            :options="[
                ['value' => 'activo', 'label' => 'Activo'],
                ['value' => 'pendiente', 'label' => 'Pendiente'],
                ['value' => 'completado', 'label' => 'Completado'],
            ]"
        />
    </div>

    {{-- Select nativo con opciones simples --}}
    <div class="bg-white p-4 rounded shadow">
        <h3 class="font-bold mb-2">Select Nativo (Opciones Simples)</h3>
        <wire-native-select 
            wire:model="categoria"
            label="Categoría"
            placeholder="Seleccione una categoría"
            :options="['Tecnología', 'Soporte', 'Ventas', 'Marketing']"
        />
    </div>

    {{-- ============================================ --}}
    {{-- 3. CHECKBOX - Casilla de verificación --}}
    {{-- ============================================ --}}
    <div class="bg-white p-4 rounded shadow">
        <h3 class="font-bold mb-2">3. Checkbox Simple</h3>
        <wire-checkbox 
            id="aceptar"
            wire:model="aceptado"
            label="Acepto los términos y condiciones"
        />
    </div>

    {{-- Checkbox sin label --}}
    <div class="bg-white p-4 rounded shadow">
        <h3 class="font-bold mb-2">Checkbox con Label Personalizado</h3>
        <div class="flex items-center">
            <wire-checkbox 
                id="notificaciones"
                wire:model="recibirNotificaciones"
            />
            <label for="notificaciones" class="ml-2 text-sm text-gray-700">
                Deseo recibir notificaciones por email
            </label>
        </div>
    </div>

    {{-- Múltiples checkboxes --}}
    <div class="bg-white p-4 rounded shadow">
        <h3 class="font-bold mb-2">Múltiples Checkboxes</h3>
        <div class="space-y-2">
            <wire-checkbox 
                id="opcion1"
                wire:model="opciones"
                value="opcion1"
                label="Opción 1"
            />
            <wire-checkbox 
                id="opcion2"
                wire:model="opciones"
                value="opcion2"
                label="Opción 2"
            />
            <wire-checkbox 
                id="opcion3"
                wire:model="opciones"
                value="opcion3"
                label="Opción 3"
            />
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- 4. TEXTAREA - Área de texto --}}
    {{-- ============================================ --}}
    <div class="bg-white p-4 rounded shadow">
        <h3 class="font-bold mb-2">4. Textarea</h3>
        <wire-textarea 
            wire:model="comentarios"
            label="Comentarios"
            placeholder="Escribe tus comentarios aquí..."
            rows="4"
        />
    </div>

    {{-- ============================================ --}}
    {{-- 5. EJEMPLO COMPLETO - Formulario --}}
    {{-- ============================================ --}}
    <div class="bg-white p-4 rounded shadow">
        <h3 class="font-bold mb-2">5. Ejemplo de Formulario Completo</h3>
        <form wire:submit="guardar">
            <div class="space-y-4">
                <wire-input 
                    wire:model="nombre"
                    label="Nombre Completo"
                    placeholder="Juan Pérez"
                    required
                />

                <wire-input 
                    type="email"
                    wire:model="email"
                    label="Email"
                    placeholder="juan@example.com"
                    required
                />

                <wire-native-select 
                    wire:model="pais"
                    label="País"
                    placeholder="Seleccione su país"
                    :options="[
                        ['value' => 'mx', 'label' => 'México'],
                        ['value' => 'us', 'label' => 'Estados Unidos'],
                        ['value' => 'co', 'label' => 'Colombia'],
                    ]"
                    required
                />

                <wire-textarea 
                    wire:model="mensaje"
                    label="Mensaje"
                    placeholder="Escribe tu mensaje..."
                    rows="5"
                />

                <wire-checkbox 
                    id="privacidad"
                    wire:model="aceptaPrivacidad"
                    label="Acepto la política de privacidad"
                />

                <wire-button type="submit" primary>
                    Enviar Formulario
                </wire-button>
            </div>
        </form>
    </div>
</div>

{{-- 
    NOTAS IMPORTANTES:
    
    1. PREFIJO: Con 'prefix' => "wire-" en config/wireui.php, los componentes se usan como:
       - <wire-input> (NO <x-wire-input> ni <x-input>)
       - <wire-native-select>
       - <wire-checkbox>
       - <wire-textarea>
       - <wire-button>
    
    2. ATRIBUTOS COMUNES:
       - wire:model: Vincula el campo a una propiedad del componente Livewire
       - label: Etiqueta del campo (se muestra automáticamente)
       - placeholder: Texto de ayuda dentro del campo
       - required: Marca el campo como obligatorio
    
    3. SELECT NATIVO:
       - Usa :options con array de arrays ['value' => 'valor', 'label' => 'Etiqueta']
       - O array simple de strings para opciones simples
    
    4. CHECKBOX:
       - Para múltiples checkboxes, usa el mismo wire:model con value diferente
       - El componente Livewire debe tener un array para almacenar múltiples valores
--}}
