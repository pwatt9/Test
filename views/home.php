<?php $this->layout('template') ?>

<div class="wrapper">
    <div class="container">
        <section>
            <h1>Properties</h1>
            <table class="table">
                <thead class="thead">
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Brand</th>
                        <th>Phone</th>
                        <th>Services</th>
                        <th>Url</th>
                        <th>Region</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="tbody">
                	<?php if (is_array($propertyArray) && !empty($propertyArray)):?>
    					<?php foreach ($propertyArray as $propertyObj): ?>
                        <tr>
                            <td><?=$propertyObj->getId()?></td>
                            <td><?=$propertyObj->getName()?></td>
                            <td><?=$propertyObj->getBrand()?></td>
                            <td><?=$propertyObj->getPhoneFormatted()?></td>
                            <td><?=$propertyObj->getIsFullServiceName()?></td>
                            <td><a href="<?=$propertyObj->getUrl()?>" target="_blank"><?=strlen($propertyObj->getUrl()) > 30?substr(trim(trim($propertyObj->getUrl(),'https://'),'http://'),0,20).'...':trim(trim($propertyObj->getUrl(),'https://'),'http://')?></a></td>
                            <td><?=$propertyObj->getRegion()->getName()?></td>
                            <td class="button_block"><form action="index.php" method="post"><input type="hidden" name="id" value="<?=$propertyObj->getId()?>"><button type="submit" name="page" value="propertyEdit"><span class="icon_img"><img src="images/edit.png"/></span></button><button type="submit" name="page" value="delete" class="delete"><span class="icon_img"><img src="images/delete.png"/></span></button></form></div></td>
                        </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">
                            	No properties found
                            </td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>

            <form class="form" action="index.php" method="post">
                <div class="form__group">
                	<input type="hidden" name="page" value="propertyAdd"/>
                    <input type="submit" value="Add Property"/>
                </div>
            </form>

        </section>
    </div>
</div>