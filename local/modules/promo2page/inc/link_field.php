<div class="module-p2p-form-item">
    <div class="module-p2p-form-ins">
        <span>Устанавливается ссылка, на которую будет вести клиента при клике на сноску с акцией.</span>
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
                value="<?=$arOption['VALUE'] ?? ''?>"
                >
        </div>
    </div>

</div>