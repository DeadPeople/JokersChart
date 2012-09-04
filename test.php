<?php
$content = 
	'{
		"width": 900,
		"line-cut": true,
		"content": [
			{
				"style": "people",
				"title": "08软院到底有多少男女生？",
				"color": "#FFFFFF",
				"background": "#08202C",
				"describe": "08软院在毕业后实际人数为232，男生有201个之多，而女生则只有区区可怜的31个。男女比例达到了恐怖的7:1！所以说，各位宅男如果想追到软院的妹子。可需要好好努力哦~",
				"describe-color": "white",
				"objects": 
				[
					{
						"size": 41,
						"color": "#92D9F9",
						"title": "boy",
						"value": "20"
					},
					{
						"size": 33,
						"color": "#E58384",
						"title": "girl",
						"value": "3"
					}
				]
			},
			
			{
				"style": "histogram",
				"title": "08软院所学到的知识",
				"color": "#FFFFFF",
				"background": "#08202C",
				"describe": "如果你以为到了软院学的就只有如何编码那可就大错特错了，其实除了代码我们还要学习很多其他的东东。俗话说的好书山有路勤为径，学海无涯苦作舟。如果单单学习写代码，那可就要成码农咯~",
				
				"height": 250,
				"radius": "5,5,0,0",
				
				"objects": 
				[
					{
						"title": "软件工程",
						"value": "27"
					},
					{
						"title": "体育",
						"value": "6",
						"color": "#92D9F9"
					},
					{
						"title": "政治历史",
						"value": "5",
						"color": "#0092BB",
						"describe": "好吧，这门课或许不能避免你不当码农……"
					},
					{
						"title": "公共选修",
						"value": "8",
						"color": "#E58384"
					},
					{
						"title": "数学",
						"value": "3",
						"color": "#FBB03B"
					},
					{
						"title": "其他",
						"value": "5",
						"color": "#CACB6D"
					}
				]
			},
			
			{
				"style": "line-histogram",
				"title": "08软院的语言覆盖",
				"color": "#FFFFFF",
				"background": "#08202C",
				"describe": "由于软院的标准课程是学习JAVA，因而所有的童鞋都会使用JAVA。此外，除了课程需要的语言外，大家也会自学其他的编程语言。例如C++、C#、Python、Ruby、AS等等。",
				
				"object-height": 62,
				"object-background": "#2A495E",
				"object-title-color": "white",
				
				"objects": 
				[
					{
						"title": "JAVA",
						"value": "100",
						"front-color": "#E58384",
						"title-color": "#FDFDFD"
					},
					{
						"title": "C++",
						"value": "50",
						"front-color": "#0092BB"
					},
					{
						"title": "C#",
						"value": "30",
						"front-color": "#A9AA5A"
					},
					{
						"title": "Other",
						"value": "20",
						"front-color": "#818591"
					}
				]
			},
			
			{
				"style": "sector",
				"title": "08软院的校园生活比",
				"color": "#FFFFFF",
				"background": "#08202C",
				"describe": "你以为在学校只有学习么？那你就大错特错啦。当然了，如果要当学霸那我也没什么办法。就一般童鞋的校园生活而言，学习和娱乐会占用大头。而社团（包括学生会等等），则是部分人参加~",
				
				"title-color": "white",
				"value-color": "#08202C",
				"radius": 150,
				"distance": 7,
				
				"objects": 
				[
					{
						"title": "学习",
						"value": "100",
						"background-color": "#E58384",
						"title-color": "#F5F5F5",
						"value-color": "#082020",
						"describe": "nothing!",
						"distance": 7
					},
					{
						"title": "社团",
						"value": "55",
						"background-color": "#FBB03B"
					},
					{
						"title": "娱乐",
						"value": "85",
						"background-color": "#CACB6D"
					},
					{
						"title": "其他",
						"value": "30",
						"background-color": "#818591"
					}
				]
			},
			
			{
				"style": "line_list",
				"title": "08届最多活动的院系",
				"color": "#FFFFFF",
				"background": "#08202C",
				"describe": "毫无疑问，大学生活中少了各个院系社团办的活动怎么行？今天有个摄影大赛、明天来个绘画大赛。又或者秋游踏青，野外自主烧烤。人生充满了趣味，那你知道哪些院系办的活动最多么？",
				
				"height": "100",
				"title-color": "#D57C7E",
				"line-color": "#D57C7E",
				"border-weight": "5",
				"title-position": "right",
				
				"objects": 
				[
					{
						"title": "软院学院",
						"title-color": "#E68D8F"
					},
					{
						"title": "商学院"
					},
					{
						"title": "大气科学"
					},
					{
						"title": "物理学院"
					},
					{
						"title": "校学生会"
					}
				]
			}
		]
	}';
$content = iconv('gb2312','utf-8',$content);
?>