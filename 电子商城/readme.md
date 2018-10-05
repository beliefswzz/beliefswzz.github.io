<pre>
项目描述：
	类似于京东商城<br>
<h1><center>购物车</center></h1>
	<h3><center>/************************************ 加入购物车********************************************/</center><h3><center>
	public function addToCart($goods_id, $goods_attr_id, $goods_number = 1)
	{
		$mid = session('mid');
		// 如果登录了就加入到数据库中，否则就加入到COOKIE中
		if($mid)
		{
			$cartModel = M('Cart');
			$has = $cartModel->where(array(
				'member_id' => array('eq', $mid),
				'goods_id' => array('eq', $goods_id),
				'goods_attr_id' => array('eq', $goods_attr_id),
			))->find();
			// 判断是否商品已经存在
			if($has)
				$cartModel->where('id='.$has['id'])->setInc('goods_number', $goods_number);
			else 
				$cartModel->add(array(
					'goods_id' => $goods_id,
					'goods_attr_id' => $goods_attr_id,
					'goods_number' => $goods_number,
					'member_id' => $mid,
				));
		}
		else 
		{
			// 先从COOKIE中取出购物车的数组
			$cart = isset($_COOKIE['cart']) ? unserialize($_COOKIE['cart']) : array();
			// 把商品加入到这个数组中
			$key = $goods_id . '-' . $goods_attr_id;
			// 先判断数组中有没有这件商品
			if(isset($cart[$key]))
				$cart[$key] += $goods_number;
			else
				$cart[$key] = $goods_number;
			// 把这个数组存回到cookie
			$aMonth = 30 * 86400;
			setcookie('cart', serialize($cart), time() + $aMonth, '/', '34.com');
		}
	}

	
<h3><center>/************************************购物车列表********************************************/</center></h3>
	public function cartList()
	{
		$mid = session('mid');
		if($mid)
		{
			$cartModel = M('Cart');
			$_cart = $cartModel->where(array('member_id'=>array('eq', $mid)))->select();
		}
		else 
		{
			$_cart_ = isset($_COOKIE['cart']) ? unserialize($_COOKIE['cart']) : array();
			// 转化这个数组结构和从数据库中取出的数组结构一样，都是二维的
			$_cart = array();
			foreach ($_cart_ as $k => $v)
			{
				// 从下标中解析出商品ID和商品属性ID
				$_k = explode('-', $k);
				$_cart[] = array(
					'goods_id' => $_k[0],
					'goods_attr_id' => $_k[1],
					'goods_number' => $v,
					'member_id' => 0,
				);
			}
		}
	取出商品详情页信息
		$goodsModel = D('Admin/Goods');
		foreach ($_cart as $k => $v)
		{
			$ginfo = $goodsModel->field('sm_logo,goods_name')->find($v['goods_id']);
			$_cart[$k]['goods_name'] = $ginfo['goods_name'];
			$_cart[$k]['sm_logo'] = $ginfo['sm_logo'];
			// 计算会员价格
			$_cart[$k]['price'] = $goodsModel->getMemberPrice($v['goods_id']);
			// 把商品属性ID转化成商品属性字符串
			$_cart[$k]['goods_attr_str'] = $goodsModel->convertGoodsAttrIdToGoodsAttrStr($v['goods_attr_id']);
		}
		return $_cart;
	}
	
	
<h3><center>/************************************ 把COOKIE中的数据转移到数据库中并清空COOKIE中的数据********************************************/</center></h3>
	public function moveDataToDb()
	{
		$mid = session('mid');
		if($mid)
		{
			// 先从COOKIE中取出购物车的数据
			$cart = isset($_COOKIE['cart']) ? unserialize($_COOKIE['cart']) : array();
			if($cart)
			{
				// 循环每件商品加入到数据库中
				foreach ($cart as $k => $v)
				{
					// 从下标出解析出商品ID，和商品属性ID
					$_k = explode('-', $k);
					$this->addToCart($_k[0], $_k[1], $v);
				}
				// 清空COOKIE中的数据
				setcookie('cart', '', time()-1, '/', '34.com');
			}
		}
	}
<h3><center>/************************************ 更新购物车********************************************/</center></h3>
	public function updateData($gid, $gaid, $gn)
	{
		$mid = session('mid');
		if($mid)
		{
			$cartModel = M('Cart');
			if($gn == 0)
				$cartModel->where(array(
					'goods_id' => array('eq', $gid),
					'goods_attr_id' => array('eq', $gaid),
					'member_id' => array('eq', $mid),
				))->delete();
			else 
				$cartModel->where(array(
					'goods_id' => array('eq', $gid),
					'goods_attr_id' => array('eq', $gaid),
					'member_id' => array('eq', $mid),
				))->setField('goods_number', $gn);
		}
		else 
		{
			// 先从COOKIE中取出购物车的数组
			$cart = isset($_COOKIE['cart']) ? unserialize($_COOKIE['cart']) : array();
			$key = $gid . '-' . $gaid;
			if($gn == 0)
				unset($arr[$key]);
			else
				$arr[$key] = $gn;
			// 把这个数组存回到cookie
			$aMonth = 30 * 86400;
			setcookie('cart', serialize($cart), time() + $aMonth, '/', '34.com');
		}
	}
————————————————————————————————————————————————————————————————
————————————————————————————————————————————————————————————————
————————————————————————————————————————————————————————————————
<h1><center>权限管理</center><h1>
	
<h3><center>/************************************ 返回权限列表********************************************/</center></h3>
	public function getTree()
	{
		$data = $this->select();
		return $this->_reSort($data);
	}
       根据主权限找出子权限，并返回权限列表	
	private function _reSort($data, $parent_id=0, $level=0, $isClear=TRUE)
	{
		static $ret = array();
		if($isClear)
			$ret = array();
		foreach ($data as $k => $v)
		{
			if($v['parent_id'] == $parent_id)
			{
				$v['level'] = $level;
				$ret[] = $v;
				$this->_reSort($data, $v['id'], $level+1, FALSE);
			}
		}
		return $ret;
	}
     
<h3><center>/************************************ 根据id找出对应的权限，并返回********************************************/</center></h3>
	public function getChildren($id)
	{
		$data = $this->select();
		return $this->_children($data, $id);
	}
     	
<h3><center>/************************************ 根据id找出子权限列表，并返回权限列表，并返回********************************************/</center><h3><center>	
	private function _children($data, $parent_id=0, $isClear=TRUE)
	{
		static $ret = array();
		if($isClear)
			$ret = array();
		foreach ($data as $k => $v)
		{
			if($v['parent_id'] == $parent_id)
			{
				$ret[] = $v['id'];
				$this->_children($data, $v['id'], FALSE);
			}
		}
		return $ret;
	}
	<h3><center>/************************************ 其他方法 ********************************************/</center></h3>
	
     
<h3><center>/************************************ 删除主权限之前先删除所有的子权限	********************************************/</center><h3>
	public function _before_delete($option)
	{
		// 先找出所有的子分类
		$children = $this->getChildren($option['where']['id']);
		// 如果有子分类都删除掉
		if($children)
		{
			$children = implode(',', $children);
			$this->execute("DELETE FROM php34_privilege WHERE id IN($children)");
		}
	}
————————————————————————————————————————————————————————————————
————————————————————————————————————————————————————————————————
————————————————————————————————————————————————————————————————
<h1><center>商品管理</center><h1>
	    <h3><center>/**************************************** 搜索 ****************************************/</center></h3>
	public function search($pageSize = 20, $isDelete = 0)
	{

		// 是否是回收站的商品
		$where['is_delete'] = array('eq', $isDelete);
		if($goods_name = I('get.goods_name'))
			$where['goods_name'] = array('like', "%$goods_name%");
		if($cat_id = I('get.cat_id'))
			$where['cat_id'] = array('eq', $cat_id);
		if($brand_id = I('get.brand_id'))
			$where['brand_id'] = array('eq', $brand_id);
		$shop_pricefrom = I('get.shop_pricefrom');
		$shop_priceto = I('get.shop_priceto');
		if($shop_pricefrom && $shop_priceto)
			$where['shop_price'] = array('between', array($shop_pricefrom, $shop_priceto));
		elseif($shop_pricefrom)
			$where['shop_price'] = array('egt', $shop_pricefrom);
		elseif($shop_priceto)
			$where['shop_price'] = array('elt', $shop_priceto);
		$is_hot = I('get.is_hot');
		if($is_hot != '' && $is_hot != '-1')
			$where['is_hot'] = array('eq', $is_hot);
		$is_new = I('get.is_new');
		if($is_new != '' && $is_new != '-1')
			$where['is_new'] = array('eq', $is_new);
		$is_best = I('get.is_best');
		if($is_best != '' && $is_best != '-1')
			$where['is_best'] = array('eq', $is_best);
		$is_on_sale = I('get.is_on_sale');
		if($is_on_sale != '' && $is_on_sale != '-1')
			$where['is_on_sale'] = array('eq', $is_on_sale);
		if($type_id = I('get.type_id'))
			$where['type_id'] = array('eq', $type_id);
		$addtimefrom = I('get.addtimefrom');
		$addtimeto = I('get.addtimeto');
		if($addtimefrom && $addtimeto)
			$where['addtime'] = array('between', array(strtotime("$addtimefrom 00:00:00"), strtotime("$addtimeto 23:59:59")));
		elseif($addtimefrom)
			$where['addtime'] = array('egt', strtotime("$addtimefrom 00:00:00"));
		elseif($addtimeto)
			$where['addtime'] = array('elt', strtotime("$addtimeto 23:59:59"));
		<h3><center>/************************************* 翻页 ****************************************/</center></h3>
		$count = $this->alias('a')->where($where)->count();
		$page = new \Think\Page($count, $pageSize);
		// 配置翻页的样式
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$data['page'] = $page->show();
		<h3><center>/************************************** 取数据 ******************************************/</center><h3><center>
		$data['data'] = $this->field('a.*,IFNULL(SUM(b.goods_number),0) gn')->alias('a')->join('LEFT JOIN php34_goods_number b ON a.id=b.goods_id')->where($where)->group('a.id')->order('id DESC')->limit($page->firstRow.','.

$page->listRows)->select();
		return $data;
	}

protected function _after_insert($data, $option)
	{
		<h3><center>/**************** 处理商品的扩展分类 ********************/</center></h3>
		$eci = I('post.ext_cat_id');
		if($eci)
		{
			$gcModel = M('GoodsCat');
			foreach ($eci as $v)
			{
				// 如果分类为空就跳过处理下一个
				if(empty($v))
					continue;
				$gcModel->add(array(
					'goods_id' => $data['id'],
					'cat_id' => $v,
				));
			}
		}
		<h3><center>/************* 处理会员价格 ************************/</center></h3>
		$mp = I('post.mp');
		if($mp)
		{
			$mpModel = M('MemberPrice');
			foreach ($mp as $k => $v)
			{
				if(empty($v))
					continue ;
				$mpModel->add(array(
					'goods_id' => $data['id'],
					'level_id' => $k,
					'price' => $v,
				));
			}
		}
		<h3><center>/******************** 处理商品属性的数据 *********************/</center></h3>
		$ga = I('post.ga');
		$ap = I('post.attr_price');
		if($ga)
		{
			$gaModel = M('GoodsAttr');
			foreach ($ga as $k => $v)
			{
				foreach ($v as $k1 => $v1)
				{
					if(empty($v1))
						continue ;
					$price = isset($ap[$k][$k1]) ? $ap[$k][$k1] : '';
					$gaModel->add(array(
						'goods_id' => $data['id'],
						'attr_id' => $k,
						'attr_value' => $v1,
						'attr_price' => $price,
					));
				}
			}
		}
<h1><center>用户登录</center><h1>
	<h3><center>/**************************************** 用户登录 ****************************************/</center></h3>
	public function login()
	{
		// 获取表单中的用户名密码
		$username = $this->username;
		$password = $this->password;
		// 先查询数据库有没有这个账号
		$user = $this->where(array(
			'username' => array('eq', $username),
		))->find();
		// 判断有没有账号
		if($user)
		{
			// 判断是否启用(超级管理员不能禁用）
			if($user['id'] == 1 || $user['is_use'] == 1)
			{
				// 判断密码
				if($user['password'] == md5($password.C('MD5_KEY')))
				{
					// 把ID和用户名存到session中
					session('id', $user['id']);
					session('username', $user['username']);
					return TRUE;
				}
				else 
				{
					$this->error = '密码不正确！';
					return FALSE;
				}
			}
			else 
			{
				$this->error = '账号被禁用！';
				return FALSE;
			}
		}
		else 
		{
			$this->error = '用户名不存在！';
			return FALSE;
		}
	}
    <h3><center>/**************************************** 分页 ****************************************/</center></h3>
	public function search($pageSize = 20)
	{
		$where = array();
		if($username = I('get.username'))
			$where['username'] = array('like', "%$username%");
		$is_use = I('get.is_use');
		if($is_use != '' && $is_use != '-1')
			$where['is_use'] = array('eq', $is_use);
		$count = $this->alias('a')->where($where)->count();
		$page = new \Think\Page($count, $pageSize);
		// 配置翻页的样式
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$data['page'] = $page->show();
		<h3><center>/************************************** 取数据 ******************************************/</center></h3>
		$data['data'] = $this->alias('a')->where($where)->group('a.id')->limit($page->firstRow.','.$page->listRows)->select();
		return $data;
	}
    <h3><center>/************************************** 添加前******************************************/</center></h3>

    protected function _before_insert(&$data, $option)
	{
		$data['password'] = md5($data['password'] . C('MD5_KEY'));
	}
	protected function _after_insert($data, $option)
	{
		$roleId = I('post.role_id');
		if($roleId)
		{
			$arModel = M('AdminRole');
			foreach ($roleId as $v)
			{
				$arModel->add(array(
					'admin_id' => $data['id'],
					'role_id' => $v,
				));
			}
		}
	}
    <h3><center>/************************************** 修改前******************************************/</center></h3>

	protected function _before_update(&$data, $option)
	{
		// 如果是超级管理员必须是启用的
		if($option['where']['id'] == 1)
			$data['is_use'] = 1;         // 直接设置为启用状态
			
		$roleId = I('post.role_id');
		// 先清除原来的数据
		$arModel = M('AdminRole');
		$arModel->where(array('admin_id'=>array('eq', $option['where']['id'])))->delete();
		if($roleId)
		{
			foreach ($roleId as $v)
			{
				$arModel->add(array(
					'admin_id' => $option['where']['id'],
					'role_id' => $v,
				));
			}
		}
		// 判断密码为空就不修改这个字段
		if(empty($data['password']))
			unset($data['password']);
		else 
			$data['password'] = md5($data['password'] . C('MD5_KEY'));
	}
    <h3><center>/************************************** 删除前******************************************/</center></h3>

	protected function _before_delete($option)
	{
		if($option['where']['id'] == 1)
		{
			$this->error = '超级管理员不能被删除！';
			return FALSE;
		}
		// 在删除admin表中管理员的信息之前先删除admin_role表中这个管理员对应的数据s
		$arModel = M('AdminRole');
		$arModel->where(array('admin_id'=>array('eq', $option['where']['id'])))->delete();
	}
}
</pre>
