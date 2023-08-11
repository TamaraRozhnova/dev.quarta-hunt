<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<template>
    <div class="holosun">
        <client-only>
            <MainSlider :slides="mainSlider" v-if="mainSlider.length" class="holosun__slider"/>
        </client-only>
        <div v-if="about.title && about.text1 && about.text2" class="container">
            <small> О компании </small>
            <div class="row mt-3">
                <div class="col-12 col-lg-6">
                    <h2 v-html="about.title"></h2>
                    <p v-html="about.text1"></p>
                </div>

                <div class="col-12 col-lg-6">
                    <p v-html="about.text2"></p>
                </div>
            </div>
        </div>

        <div class="container" v-if="review.image && review.link && review.datev && review.text && reviewProducts.length">
            <div class="row">
                <div class="col-12 col-md-6 mb-4 mb-md-0">
                    <PromoCardVue
                            :image-as-background="true"
                            :large="true"
                            :image="review.image"
                            :link="review.link"
                            :lightTheme="true"
                            :withShadow="true"
                    >
                        <span class="mb-4" :style="{ zIndex: 1 }">{{ review.date }}</span>
                        <p>{{ review.text }}</p>
                    </PromoCardVue>
                </div>

                <div class="col-12 col-md-3 holosun__product" v-for="reviewProduct, i in reviewProducts">
                    <ProductCardVue :product="reviewProduct" :key="i"/>
                </div>
            </div>
        </div>

        <div class="container" v-if="video.title && video.text.length && video.image && video.link && video.type">
            <div class="row">
                <div class="col-12 col-md-6">

                    <h2>{{ video.title }} </h2>
                </div>
                <div class="col-12 col-md-6">
                    <p v-html="video.text[0]"></p>
                </div>
            </div>
        </div>

        <VerticallyDivided class="holosun__video" v-if="video.title && video.text.length && video.image && video.link && video.type">
            <div class="container pb-0">
                <VideoPlayerVue
                        :poster="video.image"
                        :src="video.link"
                        :type="video.type"
                />
            </div>
        </VerticallyDivided>

        <div class="bg-white pt-5" v-if="video.title && video.text.length && video.image && video.link && video.type">
            <div class="container pt-5">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <p>{{ video.text[1] }}</p>
                    </div>
                    <div class="col-12 col-md-6">
                        <p>{{ video.text[2] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <PromoWideSlider class="holosun__wide-slider" v-if="slider.length">
            <div
                    v-for="slide, i in slider"
                    :data-image="slide.background"
            >
                <h2 class="mb-4 holosun__wide-slider-title">
                    {{ slide.title }}
                </h2>
                <p v-html="slide.text"></p>
            </div>
        </PromoWideSlider>

        <div class="bg-white pt-5 holosun__row" v-if="firstDesc.title && firstDesc.text.length && firstDesc.images.length">
            <div class="container pt-5">
                <div class="row py-5">
                    <div
                            class="
              col-12
              d-flex
              flex-column
              justify-content-center
              align-content-start
              col-md-6
            "
                    >
                        <h2 class="mb-4">
                            {{ firstDesc.title }}
                        </h2>

                        <p>{{ firstDesc.text[0] }}</p>
                    </div>

                    <div class="col-12 d-flex justify-content-end align-content-center col-md-6">
                        <img :src="firstDesc.images[0]" alt="Holosun" class="holosun__contain-img"/>
                    </div>
                </div>

                <div class="row py-2 py-lg-5 mt-5">
                    <div class="col-12 d-flex justify-content-start align-content-center col-md-6 mb-5">
                        <img :src="firstDesc.images[1]" alt="Holosun" class="holosun__contain-img" />
                    </div>
                    <div
                            class="
              col-12
              d-flex
              flex-column
              justify-content-center
              align-content-start
              col-md-6
            "
                    >
                        <p>{{ firstDesc.text[1] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="reviewProducts.length && catalogSection.products.length && catalogSection.title && catalogSection.link" class="bg-gray-100 py-5 holosun__products">
            <div class="container py-5">
                <div class="row py-5">
                    <div
                            class="
              col-12
              mb-4
              d-flex
              justify-content-between
              align-items-center
              holosun__products-row
              flex-wrap
              flex-md-nowrap
            "
                    >
                        <h3 class="text-left me-auto">{{ catalogSection.title }}</h3>

                        <router-link :to="catalogSection.link" class="d-inline-block text-nowrap me-auto text-md-end me-md-0">Перейти в каталог</router-link>
                    </div>
                    <div class="col-3 holosun__product mb-3 mb-md-0" v-for="catalogSectionProduct, i in catalogSection.products">
                        <ProductCardVue :product="catalogSectionProduct" :key="i"/>
                    </div>
                </div>
            </div>
        </div>

        <PromoWideSlider class="holosun__wide-slider" v-if="abilities.length">
            <div
                    v-for="ability, i in abilities"
                    :data-image="ability.background"
            >
                <h2>{{ ability.title }}</h2>
                <div class="checklist" v-html="ability.description">
                </div>
            </div>
        </PromoWideSlider>

        <div class="bg-white py-lg-5 overflow-hidden" v-if="secondDesc.text && secondDesc.warning && secondDesc.image">
            <div class="container py-lg-5">
                <div class="row py-5 holosun__price-descr">
                    <div class="col-12 d-flex flex-column justify-content-center col-lg-5 ">
                        <h2 class="mb-4"></h2>

                        <p v-html="secondDesc.text"></p>

                        <div class="bg-primary text-white p-5 mt-5 q-small">
                            <p class="m-0" v-html="secondDesc.warning"></p>
                        </div>
                    </div>

                    <div class="col-1 d-none d-lg-block"></div>

                    <div
                            class="
              col-12
              d-flex
              flex-column
              justify-content-center
              align-items-start
              ps-lg-5
              col-lg-6
              holosun__price-img
            "
                    >
                        <img :src="secondDesc.image" class="holosun__contain-img ms-lg-5" alt="Holosun" />
                    </div>
                </div>

                <div class="row py-3 py-lg-5 holosun__advant" v-if="thirdDesc.image && thirdDesc.title && thirdDesc.text">
                    <div
                            class="
              col-6
              d-flex
              flex-column
              justify-content-center
              align-items-start
            "
                    >
                        <img :src="thirdDesc.image" alt="Holosun" class="holosun__contain-img" />
                    </div>
                    <div class="col-6 d-flex flex-column justify-content-center">
                        <h2 class="mb-4">{{ thirdDesc.title }}</h2>
                        <p v-html="thirdDesc.text"></p>
                    </div>
                </div>

                <div class="row pt-3 pt-lg-5" v-if="assort.title">
                    <div class="col-8 holosun__assort">
                        <small> Ассортимент </small>
                        <h2 class="mt-2">{{ assort.title }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="holosun__series-tabs bg-white d-md-none">
            <div class="holosun__series-tabs-wr">
                <h2
                        class="d-flex w-50 align-items-center"
                        v-if="assort.first"
                        @click="openedAssort = assort.first.class"
                        :class="{'active': openedAssort === assort.first.class}"
                >
                    <img :src="assort.first.classIcon" />
                    {{ assort.first.class }}
                </h2>
                <h2
                        class="d-flex w-50 align-items-center"
                        v-if="assort.second"
                        @click="openedAssort = assort.second.class"
                        :class="{'active': openedAssort === assort.second.class}"
                >
                    <img :src="assort.second.classIcon" />
                    {{ assort.second.class }}
                </h2>
            </div>
        </div>

        <div class="bg-white series">
            <div class="container">
                <div class="row holosun__series">
                    <div
                            class="col-6 p-5 ps-0"
                            v-if="assort.first"
                            :class="{'open': openedAssort === assort.first.class}"
                    >
                        <h2 class="d-none d-md-flex justify-content-between align-items-center pb-2">
                            {{ assort.first.class }}
                            <img :src="assort.first.classIcon" />
                        </h2>

                        <hr />

                        <figure>
                            <img :src="assort.first.image" />
                        </figure>

                        <p v-html="assort.first.text"></p>

                        <div class="row mt-5 pt-lg-5">
                            <div class="col-6 holosun__product" v-for="assortProduct, i in assort.first.products">
                                <ProductCardVue
                                        :product="assortProduct"
                                        :key="i"
                                />
                            </div>
                        </div>
                    </div>

                    <div
                            class="col-6 p-5 pe-0"
                            v-if="assort.second"
                            :class="{'open': openedAssort === assort.second.class}"
                    >
                        <h2 class="d-none d-md-flex justify-content-between align-items-center pb-2">
                            {{ assort.second.class }}
                            <img :src="assort.second.classIcon" />
                        </h2>

                        <hr />

                        <figure>
                            <img :src="assort.second.image" />
                        </figure>

                        <p v-html="assort.second.text"></p>

                        <div class="row mt-5 pt-lg-5">
                            <div
                                    class="col-6 holosun__product"
                                    v-for="assortProduct, i in assort.second.products"
                                    :key="i"
                            >
                                <ProductCardVue
                                        :product="assortProduct"
                                />
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="bg-white pb-5" v-if="assortmentSlider.length">
            <BaseSliderVue class="holosun__rulers" :options="sliderOptions">
                <div
                        class="row slider-card holosun__ruler"
                        v-for="assortmentItem, i in assortmentSlider"
                        :key="i"
                >
                    <div class="col-6">
                        <figure>
                            <img :src="assortmentItem.image" alt="Holosun" class="holosun__contain-img" />
                        </figure>
                    </div>
                    <div class="col-6">
                        <h3 class="mb-4">{{ assortmentItem.title }}</h3>
                        <div v-html="assortmentItem.text"></div>

                        <router-link :to="assortmentItem.link" class="btn btn-primary mt-4">Перейти в каталог</router-link>
                    </div>
                </div>
            </BaseSliderVue>
        </div>

        <div class="bg-gray-100 py-5" v-if="conditions.title && conditions.text && conditions.image">
            <div class="container py-0 py-lg-5">
                <div class="row py-lg-5 holosun__about">
                    <div class="col-6">
                        <h3 v-html="conditions.title"></h3>
                    </div>
                    <div class="col-6">
                        <p v-html="conditions.text"></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-100 bg-black">
            <img
                    :src="conditions.image"
                    class="img-fluid d-block mx-auto"
                    alt="Holosun"
            />
        </div>
        <div class="bg-gray-200 py-5 q-end" v-if="conditions.blocks.length">
            <div class="container py-lg-5">
                <div class="row py-lg-5 holosun__for">

                    <div class="col-6">
                        <CabinetSectionVue>
                            <template #header>
                                <h3 class="my-3">Для <router-link :to="conditions.blocks[0].link">{{ conditions.blocks[0].title }}</router-link></h3>
                            </template>

                            <p v-html="conditions.blocks[0].text"></p>

                            <router-link :to="conditions.blocks[0].link" class="btn btn-primary py-3 px-5 mt-2 mb-3">
                                Подробнее
                            </router-link>
                        </CabinetSectionVue>
                    </div>

                    <div class="col-6">
                        <CabinetSectionVue>
                            <template #header>
                                <h3 class="my-3">Для <router-link :to="conditions.blocks[1].link">{{ conditions.blocks[1].title }}</router-link></h3>
                            </template>

                            <p v-html="conditions.blocks[1].text"></p>

                            <router-link :to="conditions.blocks[1].link" class="btn btn-primary py-3 px-5 mt-2 mb-3">
                                Подробнее
                            </router-link>
                        </CabinetSectionVue>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<div class="news-detail">
	<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
		<img
			class="detail_picture"
			border="0"
			src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>"
			width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>"
			height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>"
			alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>"
			title="<?=$arResult["DETAIL_PICTURE"]["TITLE"]?>"
			/>
	<?endif?>
	<?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
		<span class="news-date-time"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></span>
	<?endif;?>
	<?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
		<h3><?=$arResult["NAME"]?></h3>
	<?endif;?>
	<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arResult["FIELDS"]["PREVIEW_TEXT"]):?>
		<p><?=$arResult["FIELDS"]["PREVIEW_TEXT"];unset($arResult["FIELDS"]["PREVIEW_TEXT"]);?></p>
	<?endif;?>
	<?if($arResult["NAV_RESULT"]):?>
		<?if($arParams["DISPLAY_TOP_PAGER"]):?><?=$arResult["NAV_STRING"]?><br /><?endif;?>
		<?echo $arResult["NAV_TEXT"];?>
		<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?><br /><?=$arResult["NAV_STRING"]?><?endif;?>
	<?elseif($arResult["DETAIL_TEXT"] <> ''):?>
		<?echo $arResult["DETAIL_TEXT"];?>
	<?else:?>
		<?echo $arResult["PREVIEW_TEXT"];?>
	<?endif?>
	<div style="clear:both"></div>
	<br />
	<?foreach($arResult["FIELDS"] as $code=>$value):
		if ('PREVIEW_PICTURE' == $code || 'DETAIL_PICTURE' == $code)
		{
			?><?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?
			if (!empty($value) && is_array($value))
			{
				?><img border="0" src="<?=$value["SRC"]?>" width="<?=$value["WIDTH"]?>" height="<?=$value["HEIGHT"]?>"><?
			}
		}
		else
		{
			?><?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?=$value;?><?
		}
		?><br />
	<?endforeach;
	foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>

		<?=$arProperty["NAME"]?>:&nbsp;
		<?if(is_array($arProperty["DISPLAY_VALUE"])):?>
			<?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
		<?else:?>
			<?=$arProperty["DISPLAY_VALUE"];?>
		<?endif?>
		<br />
	<?endforeach;
	if(array_key_exists("USE_SHARE", $arParams) && $arParams["USE_SHARE"] == "Y")
	{
		?>
		<div class="news-detail-share">
			<noindex>
			<?
			$APPLICATION->IncludeComponent("bitrix:main.share", "", array(
					"HANDLERS" => $arParams["SHARE_HANDLERS"],
					"PAGE_URL" => $arResult["~DETAIL_PAGE_URL"],
					"PAGE_TITLE" => $arResult["~NAME"],
					"SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
					"SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
					"HIDE" => $arParams["SHARE_HIDE"],
				),
				$component,
				array("HIDE_ICONS" => "Y")
			);
			?>
			</noindex>
		</div>
		<?
	}
	?>
</div>