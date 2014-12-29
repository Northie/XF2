<?php

namespace libs\factory;

interface iProcessStep {
	public function __construct();
	public function Build();
	public function Unbuild();
	public function __destruct(); //cleanup?

}

