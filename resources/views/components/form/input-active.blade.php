
    <div class="mt-1 text-sm flex flex-col">
        <label class="inline-flex items-center">
            <input type="radio" class="form-radio" name="active" value="1"
                {{ $attributes }}>
            <span class="ml-2">Activado</span>
        </label>
        <label class="inline-flex items-center ">
            <input type="radio" class="form-radio" name="active" value="0"
                {{ $attributes }}>
            <span class="ml-2">Desactivado</span>
        </label>
    </div>
    
