<?php

namespace MoredealAiWriter\code\modules\step;

use Exception;
use MoredealAiWriter\application\client\SeastarRestfulClient;
use MoredealAiWriter\application\Plugin;
use MoredealAiWriter\code\consts\StepConstant;
use MoredealAiWriter\code\modules\context\AbstractContextModule;
use MoredealAiWriter\code\modules\step\response\AbstractResponseModule;

class SearchProductStepModule extends AbstractStepModule {

    /**
     * 获取对象时候使用
     *
     * @param $object
     *
     * @return mixed
     * @throws Exception
     */
    public static function factoryObject( $object ) {
        return parent::factoryObject( $object );
    }

    /**
     * 初始化配置
     *
     * @return void
     */
    protected function initConfig() {
        $this->name         = Plugin::translation( 'Search Product' );
        $this->desc         = Plugin::translation( 'Search for the desired product information based on multiple search criteria.' );
        $this->source       = StepConstant::SOURCE_NATIVE()->getValue();
        $this->sourceUrl    = '';
        $this->tags         = [ Plugin::translation( 'product' ) ];
        $this->icon         = Plugin::plugin_res() . '/images/search_product.svg';
        $this->isAuto       = true;
        $this->isCanAddStep = true;
    }

    /**
     * 执行步骤，查询商品
     *
     * @param AbstractContextModule $context
     *
     * @return AbstractResponseModule
     */
    public function execute( AbstractContextModule $context ): AbstractResponseModule {

        $keyword = $context->getStepVariable( 'keyword' );

        try {
            $result = SeastarRestfulClient::getInstance()->searchProduct( $keyword );

            if ( empty( $result ) || ! $result['success'] ) {

                $this->response->error( $result['errorMessage'] );

            } else {

                $records = $this->transformRecords( $result['records'] );

                $this->response->success( $records );
            }

        } catch ( \Exception $e ) {
            $this->response->error( $e->getMessage() );

            error_log( "出错了: " . $e->getMessage() );
        }

        return $this->response;
    }

    /**
     * 重构返回值
     *
     * @param $records
     *
     * @return array
     */
    public function transformRecords( $records ): array {

        $record_array = array();

        if ( ! empty( $records ) ) {
            foreach ( $records as $record ) {
                $record_array[] = [
                    'code'        => $record['code'],
                    'title'       => $record['title'],
                    'price'       => $record['price'],
                    'product_url' => $record['url'],
                    'pic_url'     => $record['picUrl'],
                    'description' => $this->getDescription( $record['productOriginalDetail'] ),
                    'points'      => $this->getPoints( $record['productOriginalDetail'] ),
                    'qa'          => $this->mockQA(),
                    'comment'     => $this->mockComment(),
                ];
            }
        }

        return $record_array;

    }

    /**
     * 获取商品描述
     *
     * @param $productDetail
     *
     * @return string
     */
    public function getDescription( $productDetail ): string {
        $description = " ";

        $descriptionStart = strpos( $productDetail, '[description]' );
        if ( $descriptionStart !== false ) {
            $descriptionEnd = strpos( $productDetail, '[fivePoint]' );
            $description    = substr( $productDetail, $descriptionStart + 13, $descriptionEnd - $descriptionStart - 13 );
        }

        return $description;
    }

    /**
     * 获取商品五点
     *
     * @param $productDetail
     *
     * @return string
     */
    public function getPoints( $productDetail ): string {
        $fivePoint = " ";

        $fivePointStart = strpos( $productDetail, '[fivePoint]' );
        if ( $fivePointStart !== false ) {
            $fivePoint = substr( $productDetail, $fivePointStart + 11 );
        }

        return $fivePoint;
    }

    /**
     * 获取商品QA
     *
     * @return string
     */
    public function mockQA(): string {
        return "## QA
Question: Are these good for flat feet?
Answer: 
1. I'm not a medical physician, however I do know these shoes are extremely comfortable on my feet. I was very surprised.
2. Very comfortable; however negligible support for flat feet or overproduction. The sole quickly wears down.
3. My arches are extremely low and these did not have enough arch support for me, unfortunately. I'm going to try some orthotics to see if I can wear them, because other than the arch issue, they're comfortable.";
    }

    /**
     * 获取商品评论
     *
     * @return string
     */
    public function mockComment(): string {

        return "## Comment
commenter: S. Robin;
star: 4;
reviewed_time: March 6, 2023;
comment: Order them to wear for work with my scrubs I usually prefer men tenni because ,they are made little more durable than ladies, but I would not be wearing them daily because I switch out my Tennis shoes daily. They are a little bit wide but somewhat satisfied love the color the color I was looking for so not sure how well they’re going to hold up if you were to wear them daily or use them for running but they seem to be made pretty well satisfied so far.;
helpful_number: 2;";

    }
}