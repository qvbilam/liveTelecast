var rollImg,imgCon,dotUl,pre;
    var imgList=[],
        bnList=[],
        position=0,
        direction="",
        imgMoveBool=false,
        speed=20,
        time=150,
        autoBool=false,
        //不改前两个图，后面的图是轮播图，接口请求出来push就ok了。
        imgSrcList=["left.png","right.png","a.jpeg","b.jpeg","c.jpeg","d.jpeg","e.jpeg"];
        // console.log(window)
        var bodys=document.getElementsByTagName("body")
        console.log(bodys[0])
        var IMG_WIDTH=window.document.body.offsetWidth;
        console.log();
        window.onresize=function(){
            IMG_WIDTH=window.document.body.offsetWidth;
        }
    
    // const IMG_WIDTH=500
    // console.log(IMG_WIDTH,'##################')
    const IMG_HEIGHT=200;
    function carousel(parent) {
        loadImages(parent);
    }
    
    /*
    * 异步获取图片,返回一个promise
    * 创建图片,并且根据传入参数的src,加载图片,如果加载完成,执行res函数
    *
    * */
    function getImage(src) {
        return new Promise(function (res,rej) {
            var img=new Image();
            img.src=src;
            img.onload=function () {
                res(img);
            }
        })
    }
    /*
    *  加载多个图片
    *  将所有图片地址,创建一个数组,数组中都是上面的加载图片的promise
    *  使用Promise.all(promise列表)返回所有加载好的图片列表
    *
    *
    * */
    function loadImages(parent) {
        var list=[];
        for(var i=0;i<imgSrcList.length;i++){
            list.push(getImage("./img/"+imgSrcList[i]));
        }
        Promise.all(list).then(function (_imgList) {
    //                _imgList就是所有加载完的图片数组
            bnList=_imgList.splice(0,2);//leftBn和rightBn;
            imgList=_imgList.splice(0);
    //                创建轮播图容器
            createRollImage(parent);
    //                创建左右按钮
            createLeftRight();
    //                创建小圆点列表
            createDotList();
    //                设置当前position对应的小圆点样式
            setDotStyle();
    //                当鼠标滑入轮播图和滑出轮播图的侦听事件
            rollImg.addEventListener("mouseenter",mouseHandler);
            rollImg.addEventListener("mouseleave",mouseHandler);
    //                开始动画
            animation();
        })
    }
    
    /*
    *  当鼠标滑入时,设置autoBool是false,表示不能自动轮播
    *  滑出时,autoBool是true,可以开始自动轮播,并且让时间回复150;
    *
    *
    * */
    function mouseHandler(e) {
        if(e.type==="mouseenter"){
            autoBool=false;
        }else if(e.type==="mouseleave"){
            autoBool=true;
            time=150;
        }
    }
    /*
    *  创建轮播图容器
    *
    *
    * */
    
    function createRollImage(parent) {
        rollImg=$c("div",{
            width:IMG_WIDTH+"px",
            height:IMG_HEIGHT+"px",
            position:"relative",
            margin:"auto",
            overflow:"hidden"
        },parent);
        imgCon=$c("div",{
            width:IMG_WIDTH+"px",
            height:IMG_HEIGHT+"px",
            position:"absolute"
        },rollImg);
    //            设置图片列表中所有图片的宽高是固定宽高
        for(var i=0;i<imgList.length;i++){
            imgList[i].style.width=IMG_WIDTH+"px";
            imgList[i].style.height=IMG_HEIGHT+"px";
        }
    //            将第一张图片放入在图片容器中
        imgCon.appendChild(imgList[0]);
    }
    
    /*
    *
    * 创建左右按钮
    *
    * */
    function createLeftRight() {
    //            根据bnList循环将按钮放入在rollImg这个容器中
        for(var i=0;i<bnList.length;i++){
            rollImg.appendChild(bnList[i]);
            bnList[i].style.position="absolute";
    //                设置每个按钮垂直居中
            bnList[i].style.top=(IMG_HEIGHT-bnList[i].height)/2+"px";
            bnList[i].addEventListener("click",clickHandler);
            if(i===0){
                bnList[i].style.left="10px";
                continue;
            }
            bnList[i].style.right="10px";
    
        }
    }
    /*
    *  创建小圆点列表
    *
    *
    * */
    function createDotList() {
        dotUl=$c("ul",{
            listStyle:"none",
            margin:"0",
            padding:"0",
            position:"absolute",
            bottom:"10px"
        },rollImg);
        for(var i=0;i<imgList.length;i++){
            $c("li",{
                width:"15px",
                height:"15px",
                borderRadius:"8px",
                border:"1px solid #FF0000",
                marginLeft:"10px",
                float:"left"
            },dotUl);
        }
    //            让小圆点列表水平居中
        dotUl.style.left=(IMG_WIDTH-dotUl.offsetWidth)/2+"px";
    //            侦听ul点击事件
        dotUl.addEventListener("click",dotClickHandler);
    }
    
    /*
    * 设置小圆点样式
    *
    * */
    function setDotStyle() {
    //            让上一次的小圆点背景色透明
        if(pre){
            pre.style.backgroundColor="rgba(255,0,0,0)";
        }
    //            当前的小圆点是ul的子元素,这个子元素刚好和position值相同
        pre=dotUl.children[position];
    //            设置当前小圆点的背景色是红色半透
        pre.style.backgroundColor="rgba(255,0,0,0.3)";
    }
    
    /*
    *  点击小圆点按钮
    *  如果当前轮播图正在播放,不允许点击,跳出
    *  如果当前点击的对象是ul,也跳出不操作
    *
    *
    * */
    function dotClickHandler(e) {
        if(imgMoveBool) return;
        if(e.target.constructor===HTMLUListElement)return;
    //            将ul中的所有li存入在数组中
        var arr=Array.from(dotUl.children);
    //            在这个数组中找到当前点击的小圆点下标
        var index=arr.indexOf(e.target);
    //            如果当前的小圆点下标和当前的position相同,不进行跳转图片,直接跳出
        if(index===position)return;
    //            如果当前的小圆点下标大于上次的position定位,我们设置方向向左,否则向右
        if(index>position){
            direction="left";
        }else{
            direction="right";
        }
    //            将当前的小圆点下标设置给position,就是我们要调转到的图片的位置
        position=index;
    //            初始化下张图
        initNextImg();
    }
    
    /*
    * 点击左右按钮的事件函数
    *如果当前轮播图正在播放动画,就跳出,不操作
    *
    *
    * */
    function clickHandler(e) {
        if(imgMoveBool) return;
    //            查找当前我们点击的按钮的地址中是否有left,确定当前点击的是left按钮还是right按钮
        if(this.src.indexOf("left")>-1){
    //                如果点击了left按钮,我们让动画向右运动,设置方向为right
            direction="right";
    //                让当前的定位递减1,如果小于0时,让他为图片的最大数量
            position--;
            if(position<0)position=imgList.length-1;
        }else{
    //                如果点击了right按钮,我们让图片向左运动,设置方向为left
            direction="left";
    //                让定位自增1
            position++;
    //                如果当前定位到最后一张图,让定位重新回到0
            if(position>imgList.length-1) position=0;
        }
    //            初始化下张图片
        initNextImg();
    }
    
    /*
    * 初始化下张图片
    * 如果方向不是right和不是left,跳出
    *
    * */
    function initNextImg() {
        if(direction!=="right" && direction!=="left") return;
    //            设置当前图片的外容器可以放入2张图片,因此设置宽度为2张图片的宽度
        imgCon.style.width=IMG_WIDTH*2+"px";
        if(direction==="right"){
    //                如果方向向右.我们在图片的外容器最前面插入下张图片,
            imgCon.insertBefore(imgList[position],imgCon.firstElementChild);
    //                并且设置当前图片外容器的位置为负的图片宽度
    //                将当前图片外容器向前拉动,显示第二张图片的样子
            imgCon.style.left=-IMG_WIDTH+"px";
        }else if(direction==="left"){
    //                如果图片的方向向左运动,直接在图片外容器尾部增加下张图片
            imgCon.appendChild(imgList[position]);
    
        }
    //            设置小圆点样式
        setDotStyle();
    //            让动画动起来
        imgMoveBool=true;
    
    }
    
    function $c(type,style,parent) {
        var elem=document.createElement(type);
        if(style){
            for(var prop in style){
                elem.style[prop]=style[prop];
            }
        }
        if(!parent) parent=document.body;
        parent.appendChild(elem);
        return elem;
    }
    /*
    * 动画
    * 1\轮播图动画
    * 2.自动轮播图动画
    *
    * */
    function animation() {
        requestAnimationFrame(animation);
        moveImg();
        rollAutoImg();
    }
    
    /*
    * 轮播图动画
    *
    * */
    function moveImg() {
    //            如果不允许运动,跳出
        if(!imgMoveBool)return;
        if(direction==="left"){
    //                如果向左运动,不断设置当前的left减去speed,每次进来都递减,这样图片就向左运动了
            imgCon.style.left=imgCon.offsetLeft-speed+"px";
    //                如果这张图片运动到左边时,图片容器的位置是负的图片宽度
            if(imgCon.offsetLeft<=-IMG_WIDTH){
    //                    让图片停止运动
                imgMoveBool=false;
    //                    删除运动过去看不见的图片,并且重设当前外容器位置,保持可以看到最新的图片
                imgCon.firstElementChild.remove();
                imgCon.style.left="0px";
            }
        }else if(direction==="right"){
    //                设置让图片向右移动
            imgCon.style.left=imgCon.offsetLeft+speed+"px";
            if(imgCon.offsetLeft>=0){
    //                    如果图片外容器移动到0的位置,让动画停止
                imgMoveBool=false;
    //                    删除上一张图片,就是最后一个图片
                imgCon.lastElementChild.remove();
            }
        }
    
    }
    /*
    *  自动轮播
    *
    * */
    function rollAutoImg() {
    //            如果自动轮播是假时,跳出
        if(!autoBool)return;
    //            time自减
        time--;
    //            当time=0时,进入后面的内容
        if(time>0)return;
    //            重设time时间间隔为150帧
        time=150;
    //            设置方向向
        direction="left";
        position++;
        if(position>imgList.length-1)position=0;
        initNextImg();
    }