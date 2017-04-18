<?php $this->layout('template') ?>

<div class="wrapper">
    <div class="container">
        <section>
            <form class="form" action="index.php" method="post">
            	<input type="hidden" name="id" value="<?=$propertyObj->getId()?>" />
                <div class="form__group">
                    <label>Name*</label>
                    <input type="text" name="name" maxlength="50" class="required" value="<?=$propertyObj->getName()?>" placeholder="Hotel Name" required />
                </div>
                <div class="form__group">
                    <label>Brand*</label>
                    <input type="text" name="brand" maxlength="25" class="required" value="<?=$propertyObj->getBrand()?>" placeholder="Brand Name" required />
                </div>
                <div class="form__group">
                    <label>Phone*</label>
                    <input type="tel" name="phone" maxlength="25" class="required" value="<?=$propertyObj->getPhoneFormatted()?>" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" placeholder="123-456-7890" required />
                </div>
                <div class="form__group">
                    <label>Services</label>
                      <input type="radio" name="isFullService" value="0" <?=$propertyObj->getIsFullService()==0?'checked':''?>> Select Service<br>
                      <input type="radio" name="isFullService" value="1" <?=$propertyObj->getIsFullService()==1?'checked':''?>> Full-Service<br>
                </div>
                <div class="form__group">
                    <label>Url*</label>
<!--                     <input type="url" name="url" maxlength="255" class="required" value="<?=$propertyObj->getUrl()?>" placeholder="http://www.yourURL.com" pattern="^(https?://)?([a-zA-Z0-9]([a-zA-ZäöüÄÖÜ0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,6}$" required /> -->
                    <input type="url" name="url" maxlength="255" class="required" value="<?=$propertyObj->getUrl()?>" placeholder="http://www.yourURL.com" pattern="/^((https|http|ftp)\:\/\/)?([a-z0-9A-Z]+\.[a-z0-9A-Z]+\.[a-z0-9A-Z]+\.[a-zA-Z]{2,4}|[a-z0-9A-Z]+\.[a-z0-9A-Z]+\.[a-zA-Z]{2,4}|[a-z0-9A-Z]+\.[a-zA-Z]{2,4})$/i" required />
                </div>
                <div class="form__group">
                    <label>Region</label>
                    <select name="regionId">
                    	<?php foreach($regionObjArray as $regionObj):?>
                    	<option value="<?=$regionObj->getId()?>" <?=$regionObj->getId()==$propertyObj->getRegionId()?'selected="selected"':''?>><?=$regionObj->getName()?></option>
                    	<?php endforeach;?>
                    </select>
                </div>
                <div class="form__group">
                	<input type="hidden" name="action" value="<?=$action?>" />
                    <input type="submit" name="<?=$action?>" value="<?=$action?> Property"/>
                    <input type="submit" name="cancel" value="Cancel" onclick="$('.required').removeAttr('required');"/>
                </div>
            </form>
        </section>
    </div>
</div>


