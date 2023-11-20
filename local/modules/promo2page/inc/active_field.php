<div class="module-p2p-form-item">
    <div class="module-p2p-form-ins">
        <span>Устанавливается активность, которая регулирует отображение сноски с акцией.</span>
    </div>
    <div class="module-p2p-form-label-content">
        <div class="module-p2p-form-label">
            <span>
                <?=$arOption['NAME']?>
            </span>
        </div>
        <div class="module-p2p-form-content">
            <input 
                type= '<?=$arOption['TYPE']?>' 
                name= '<?=$arOptionKey?>' 
                <?=
                    $arOption['VALUE'] == 'on' 
                    ? 'checked' 
                    : null
                ?>
            >
        </div>
    </div>
</div>