<?php

namespace endpoints\web;

class index {
	use \endpoints\endpoint;

	public function __construct($request, $response, $filters) {
		$this->filters = $filters;
		$filters = $this->filterInsertBefore('view', 'action');
	}

	public function Execute() {
		$this->data = ['dummy'=>'data'];
        
        return;

		$string = <<<'EOD'
>>this.user.firstname<<
lorum ipsupo
>>this.data.product[1].id<<
dolor sit
>>$api(product/1/attributes as product){
	product.name
}<<
amel lavec
>>$each(this.data.order as order) {
<a href='/orders?order_id=>>order.id<<">Your Order</a>
}<<
avec moi
>>$each($api(payments/search?order_id=this.data.order) as payment_list) {
	payment_list.type
}<<
foo bar
$define(foo, api(/products/1))
baz qak
>>foo.id<<
duk et tu
EOD;

		$lexer = new \tokenizer\template($string);

		$lexer->run();

		$this->data['stream'] = $lexer->getStream();

		$tree = new \tokenizer\syntaxTree();
		$tree->setStream($this->data['stream']);
		$tree->toTree();
		$list = $tree->getTree();

		print_r($list);
	}

}