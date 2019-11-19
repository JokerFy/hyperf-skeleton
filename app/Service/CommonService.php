<?php
/**
 * Created by PhpStorm.
 * User: fin
 * Date: 2019/11/12
 * Time: 11:03
 */

namespace App\Service;


use Phper666\JwtAuth\Jwt;

class CommonService
{
    // 密码加密
    public function setPassword($pwd,$salt)
    {
        $pwd = md5(md5($pwd).$salt);
        return $pwd;
    }

    //生成随机字符串
    function getRandChar($length)
    {
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol) - 1;
        for ($i = 0;
             $i < $length;
             $i++) {
            $str .= $strPol[rand(0, $max)];
        }
        return $str;
    }

    /**
     * 将菜单进行无限极递归分类
     * @param $menuData
     * @param int $parent_id
     * @return array
     */
    public function treeData($menuData,$parent_id=0){
        $treeData = [];
        foreach ($menuData as $key => $val){
            if($val['parent_id'] == $parent_id){
                //通过type将路由菜单的显示定在二级为止
                if($val['type'] == 0) {
                    $val['list'] = $this->treeData($menuData, $val['menu_id']);
                }
                $treeData[] = $val;
            }
        }
        return $treeData;
    }

    /**
     * 根据请求模型进行数据分页
     */
    public function pageList($model,$condition,$page=1,$limit=10)
    {
        if($condition['page']){
            $page = $condition['page'];
            unset($condition['page']);
        }
        if($condition['limit']){
            $limit = $condition['limit'];
            unset($condition['limit']);
        }
        //取出所有数据
        $modelData = $model->where($condition)->get();
        //分页处理
        $pageOffset = ($page-1)*$limit;
        $pageList = $model->where($condition)->skip($pageOffset)->take($limit)->get();
        $totalCount = count($modelData);
        //根据接口信息对数据进行分页
        $page = [
            //数据的总条数
            'totalCount' => $totalCount,
            'pageSize' => $limit,
            //总条数/每页的数量等于总页数
            'totalPage' => ceil($totalCount / $limit),
            'currPage' => $page,
            'list' => $pageList,
        ];
        $data['page'] = $page;
        return $data;
    }
}
