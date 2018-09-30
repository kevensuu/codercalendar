<?php

namespace CoderCalendar;

class Lucky
{
    protected $ctime;

    protected $cday;

    protected $primeNum = 11117;

    protected $weeks = ["日","一","二","三","四","五","六"];

    protected $directions = ["北方","东北方","东方","东南方","南方","西南方","西方","西北方"];

    protected $activities = [
        ["name" => "写单元测试", "good" => "写单元测试将减少出错", "bad" => "写单元测试会降低你的开发效率"],
        ["name" => "洗澡", "good" => "你几天没洗澡了？", "bad" => "会把设计方面的灵感洗掉"],
        ["name" => "锻炼一下身体", "good" => "", "bad" => "能量没消耗多少，吃得却更多"],
        ["name" => "抽烟", "good" => "抽烟有利于提神，增加思维敏捷", "bad" => "除非你活够了，死得早点没关系"],
        ["name" => "白天上线", "good" => "今天白天上线是安全的", "bad" => "可能导致灾难性后果"],
        ["name" => "重构", "good" => "代码质量得到提高", "bad" => "你很有可能会陷入泥潭"],
        ["name" => "使用%t", "good" => "你看起来更有品位", "bad" => "别人会觉得你在装逼"],
        ["name" => "跳槽", "good" => "该放手时就放手", "bad" => "鉴于当前的经济形势，你的下一份工作未必比现在强"],
        ["name" => "招人", "good" => "你遇到千里马的可能性大大增加", "bad" => "你只会招到一两个混饭吃的外行"],
        ["name" => "面试", "good" => "面试官今天心情很好", "bad" => "面试官不爽，会拿你出气"],
        ["name" => "提交辞职申请", "good" => "公司找到了一个比你更能干更便宜的家伙，巴不得你赶快滚蛋", "bad" => "鉴于当前的经济形势，你的下一份工作未必比现在强"],
        ["name" => "申请加薪", "good" => "老板今天心情很好", "bad" => "公司正在考虑裁员"],
        ["name" => "晚上加班", "good" => "晚上是程序员精神最好的时候", "bad" => ""],
        ["name" => "在妹子面前吹牛", "good" => "改善你矮穷挫的形象", "bad" => "会被识破"],
        ["name" => "撸管", "good" => "避免缓冲区溢出", "bad" => "小撸怡情，大撸伤身，强撸灰飞烟灭"],
        ["name" => "浏览成人网站", "good" => "重拾对生活的信心", "bad" => "你会心神不宁"],
        ["name" => "命名变量\"%v\"", "good" => "", "bad" => ""],
        ["name" => "写超过%l行的方法", "good" => "你的代码组织的很好，长一点没关系", "bad" => "你的代码将混乱不堪，你自己都看不懂"],
        ["name" => "提交代码", "good" => "遇到冲突的几率是最低的", "bad" => "你遇到的一大堆冲突会让你觉得自己是不是时间穿越了"],
        ["name" => "代码复审", "good" => "发现重要问题的几率大大增加", "bad" => "你什么问题都发现不了，白白浪费时间"],
        ["name" => "开会", "good" => "写代码之余放松一下打个盹，有益健康", "bad" => "你会被扣屎盆子背黑锅"],
        ["name" => "打DOTA", "good" => "你将有如神助", "bad" => "你会被虐的很惨"],
        ["name" => "晚上上线", "good" => "晚上是程序员精神最好的时候", "bad" => "你白天已经筋疲力尽了"],
        ["name" => "修复BUG", "good" => "你今天对BUG的嗅觉大大提高", "bad" => "新产生的BUG将比修复的更多"],
        ["name" => "设计评审", "good" => "设计评审会议将变成头脑风暴", "bad" => "人人筋疲力尽，评审就这么过了"],
        ["name" => "需求评审", "good" => "", "bad" => ""],
        ["name" => "上微博", "good" => "今天发生的事不能错过", "bad" => "会被老板看到"],
        ["name" => "上AB站", "good" => "还需要理由吗？", "bad" => "会被老板看到"],
    ];

    protected $drinks = ["水","茶","红茶","绿茶","咖啡","奶茶","可乐","牛奶","豆奶","果汁","果味汽水","苏打水","运动饮料","酸奶","酒"];

    public static function today($currentTime)
    {
        return (new static())->assembleData($currentTime);
    }

    protected function assembleData($currentTime)
    {
        $this->ctime = $currentTime ? $currentTime : time();
        $this->cday = date('Ymd', $this->ctime);

        $data = [];
        $data['date'] = $this->todayDesc();
        $data['direction_value'] = $this->directionValue();
        $data['drink_value'] = $this->drinkValue();
        $data['goddes_value'] = $this->goddesValue();

        $numGood = $this->random($this->cday, 98) % 3 + 2;
        $numBad = $this->random($this->cday, 87) % 3 + 2;
        $eventArr = $this->pickRandom($this->activities, ($numGood + $numBad));

        $goods = array_slice($eventArr, 0, $numGood);
        $bads = array_slice($eventArr, $numGood, $numBad);
        foreach ($goods as &$value)
        {
            $value['desc'] = $value['good'];
            unset($value['bad'], $value['good']);
        }
        unset($value);
        $data['goods_list'] = $goods;

        foreach ($bads as &$value)
        {
            $value['desc'] = $value['bad'];
            unset($value['bad'], $value['good']);
        }
        unset($value);
        $data['bads_list'] = $bads;

        return $data;
    }

    protected function todayDesc()
    {
        return "今天是".date('Y年n月d日', $this->ctime)." 星期".$this->weeks[date('w', $this->ctime)];
    }

    protected function directionValue()
    {
        return $this->directions[$this->random($this->cday, 2) % count($this->directions)];
    }

    protected function drinkValue()
    {
        return implode(',', $this->pickRandom($this->drinks, 2));
    }

    protected function goddesValue()
    {
        return $this->random($this->cday, 6) % 50 / 10.0;
    }

    protected function random($dayseed, $indexseed)
    {
        $n = $dayseed % $this->primeNum;
        $indexseed += 100;
        for ($i = 0; $i < $indexseed; $i++)
        {
            $n = $n * $n;
            $n = $n % $this->primeNum;
        }
        return $n;
    }

    protected function pickRandom($array, $size)
    {
        $length = count($array);
        $max = $length-$size;
        for ($j = 0; $j < $max; $j++)
        {
            $index = $this->random($this->cday, $j) % (count($array));
            array_splice($array, $index, 1);
        }

        return $array;
    }
}