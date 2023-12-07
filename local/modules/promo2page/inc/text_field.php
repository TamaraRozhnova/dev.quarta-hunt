<div class="module-p2p-form-item">
    <div class="module-p2p-form-ins">
        <span>Устанавливается текст, который будет отображаться в сноске с акцией на странице.</span>
    </div>
    <div class="module-p2p-form-label-content">
        <div class="module-p2p-form-label">
            <span>
                <?=$arOption['NAME']?>
            </span>
        </div>
        <div class="module-p2p-form-content">
            <input 
                type = '<?=$arOption['TYPE']?>'  
                name = '<?=$arOptionKey?>' 
                value = "<?=htmlspecialchars($arOption['VALUE']) ?? ''?>"
                >
        </div>
    </div>
</div>