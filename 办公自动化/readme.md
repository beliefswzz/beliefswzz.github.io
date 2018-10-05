<h1>项目描述:</h1>
    使用办公在线系统,我们不用再担心出差后上网查收发邮件、
    收发文件、查看公司公文公告不方便了,因为办公在线为您提
    供了所有移动办公所需要的基本功能。无论单位内部有多少个部门,
    总部外有多少个分支机构,通过本系统可以实现无地域办公,
    操作简单,稳定安全。</div>
</div>
<h1>添加用户</h1>
public function add(){
//判断请求类型
if(IS_POST){
//处理表单提交
$model = M('User');
//创建数据对象
$data = $model -> create();
//添加时间字段
$data['addtime'] = time();
//保存数据表
$result = $model -> add($data);
//判断是否保存成功
if($result){
//成功
$this -> success('添加成功！',U('showList'),3);
}else{
//失败
$this -> error('添加失败！');
}
}else{
//查询部门信息
$data = M('Dept') -> field('id,name') -> select();
//分配到模版
$this -> assign('data',$data);
//展示模版
$this -> display();
}
}

<h1>展示用户列表，并进行分页</h1>
public function showList(){
//模型实例化
$model = M('User');
//分页第一步：查询总的记录数
$count = $model -> count();
//分页第二步：实例化分页类，传递参数
$page = new \Think\Page($count,5);	//每页显示1个
//分页第三步：可选步骤，定义提示文字
$page -> rollPage = 5;
$page -> lastSuffix = false;
$page -> setConfig('prev','上一页');
$page -> setConfig('next','下一页');
$page -> setConfig('last','末页');
$page -> setConfig('first','首页');
//分页第四步：使用show方法生成url
$show = $page -> show();
//分页第五步：展示数据
$data = $model -> limit($page -> firstRow,$page -> listRows) -> select();
//分页第六步：传递给模版
$this -> assign('data',$data);
$this -> assign('show',$show);
//分页第七步：展示模版
$this -> display();
}


<h1>验证验证码</h1>
public function checkLogin(){
//接收数据
$post = I('post.');
//验证验证码（不需要传参）
$verify = new \Think\Verify();
//验证
$result = $verify -> check($post['captcha']);
//判断验证码是否正确
if($result){
//验证码正确，继续处理用户名和密码
$model = M('User');
//删除验证码元素
unset($post['captcha']);
//查询
$data = $model -> where($post) -> find();
//判断是否存在用户
if($data){
//存在用户，用户信息持久化保存到session中，跳转到后台首页
session('id',$data['id']);
session('username',$data['username']);
session('role_id',$data['role_id']);
//跳转
$this -> success('登录成功@~@',U('Index/index'),3);
}else{
//不存在
$this -> error('用户名或密码错误..');
}
}else{
//验证码不正确
$this -> error('您输出的验证码错误..');
}
}

<h1>退出方法</h1>
public function logout(){
//清除session
session(null);
//跳转到登录页面
$this -> success('退出成功',U('login'),3);
}

<h1>文件下载</h1>
public function download(){
//获取id
$id = I("get.id");
//查询数据信息
$data = M('Knowledge') -> find($id);
//下载代码
$file = WORKING_PATH . $data['picture'];
header("Content-type: application/octet-stream");
header('Content-Disposition: attachment; filename="' . basename($file) . '"');
header("Content-Length: ". filesize($file));
readfile($file);
}

<h1>发送邮件</h1>
public function send(){
//判断请求类型
if(IS_POST){
//处理数据
//接收数据
$post = I('post.');
//实例化自定义模型
$model = D('Email');
//调用具体类中方法实现数据的保存
$result = $model -> addData($post,$_FILES['file']);
//判断结果
if($result){
//成功
$this -> success('邮件发送成功！',U('sendBox'),3);
}else{
//失败
$this -> error('邮件发送失败！');
}
}else{
//展示模版
//查询收件人信息
$data = M('User') -> field('id,truename') -> where("id != " . session('id')) ->select();
//传递数据给模版文件
$this -> assign('data',$data);
//展示模版
$this -> display();
}
}

<h1>sendBox方法</h1>
public function sendBox(){
//查询当前用户已经发送的邮件
//select t1.*,t2.truename as truename from sp_email as t1 left join sp_user as t2 on t1.to_id = t2.id where t1.from_id = 当前用户的id;
$data = M("Email") -> field('t1.*,t2.truename as truename')
-> alias('t1')
-> join('left join sp_user as t2 on t1.to_id = t2.id')
-> where('t1.from_id ='.session('id'))
-> select();
//将数据传递给模版
$this -> assign('data',$data);
//展示模版
$this -> display();
}
