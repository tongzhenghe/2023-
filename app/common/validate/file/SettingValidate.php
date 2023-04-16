<?php
// +----------------------------------------------------------------------
// | yylAdmin 前后分离，简单轻量，免费开源，开箱即用，极简后台管理系统
// +----------------------------------------------------------------------
// | Copyright https://gitee.com/skyselang All rights reserved
// +----------------------------------------------------------------------
// | Gitee: https://gitee.com/skyselang/yylAdmin
// +----------------------------------------------------------------------

namespace app\common\validate\file;

use think\Validate;

/**
 * 文件设置验证器
 */
class SettingValidate extends Validate
{
    // 验证规则
    protected $rule = [
        'storage'                  => ['require'],
        'qiniu_access_key'         => ['require'],
        'qiniu_secret_key'         => ['require'],
        'qiniu_bucket'             => ['require'],
        'qiniu_domain'             => ['require'],
        'aliyun_access_key_id'     => ['require'],
        'aliyun_access_key_secret' => ['require'],
        'aliyun_bucket'            => ['require'],
        'aliyun_bucket_domain'     => ['require'],
        'aliyun_endpoint'          => ['require'],
        'tencent_secret_id'        => ['require'],
        'tencent_secret_key'       => ['require'],
        'tencent_bucket'           => ['require'],
        'tencent_region'           => ['require'],
        'tencent_domain'           => ['require'],
        'baidu_access_key'         => ['require'],
        'baidu_secret_key'         => ['require'],
        'baidu_bucket'             => ['require'],
        'baidu_domain'             => ['require'],
        'baidu_endpoint'           => ['require'],
        'upyun_service_name'       => ['require'],
        'upyun_operator_name'      => ['require'],
        'upyun_operator_pwd'       => ['require'],
        'upyun_domain'             => ['require'],
        'aws_access_key_id'        => ['require'],
        'aws_secret_access_key'    => ['require'],
        'aws_region'               => ['require'],
        'aws_bucket'               => ['require'],
        'aws_domain'               => ['require'],
        'image_size'               => ['require', '>=:0', 'float'],
        'video_size'               => ['require', '>=:0', 'float'],
        'audio_size'               => ['require', '>=:0', 'float'],
        'word_size'                => ['require', '>=:0', 'float'],
        'other_size'               => ['require', '>=:0', 'float'],
        'limit_max'                => ['require', '>:0', 'number'],
    ];

    // 错误信息
    protected $message = [
        'storage.require'                  => '请选择存储方式',
        'qiniu_access_key.require'         => '请输入 AccessKey',
        'qiniu_secret_key.require'         => '请输入 SecretKey',
        'qiniu_bucket.require'             => '请输入空间名称',
        'qiniu_domain.require'             => '请输入外链域名',
        'aliyun_access_key_id.require'     => '请输入 AccessKey ID',
        'aliyun_access_key_secret.require' => '请输入 AccessKey Secret',
        'aliyun_bucket.require'            => '请输入 Bucket 名称',
        'aliyun_bucket_domain.require'     => '请输入 Bucket 域名',
        'aliyun_endpoint.require'          => '请输入 Endpoint（地域节点）',
        'tencent_secret_id.require'        => '请输入 SecretId',
        'tencent_secret_key.require'       => '请输入 SecretKey',
        'tencent_bucket.require'           => '请输入存储桶名称',
        'tencent_region.require'           => '请输入所属地域',
        'tencent_domain.require'           => '请输入访问域名',
        'baidu_access_key.require'         => '请输入 Access Key',
        'baidu_secret_key.require'         => '请输入 Secret Key',
        'baidu_bucket.require'             => '请输入 Bucket 名称',
        'baidu_domain.require'             => '请输入官方域名',
        'baidu_endpoint.require'           => '请输入所属地域',
        'upyun_service_name.require'       => '请输入服务名称',
        'upyun_operator_name.require'      => '请输入操作员',
        'upyun_operator_pwd.require'       => '请输入操作员密码',
        'upyun_domain.require'             => '请输入加速域名',
        'aws_access_key_id.require'        => '请输入 Access Key ID',
        'aws_secret_access_key.require'    => '请输入 Secret Access KEY',
        'aws_region.require'               => '请输入区域终端节点',
        'aws_bucket.require'               => '请输入存储桶名称',
        'aws_domain.require'               => '请输入访问域名',
        'image_size.require'               => '请输入图片大小',
        'video_size.require'               => '请输入视频大小',
        'audio_size.require'               => '请输入音频大小',
        'word_size.require'                => '请输入文档大小',
        'other_size.require'               => '请输入其它大小',
        'limit_max.require'                => '请输入最大上传个数',
    ];

    // 验证场景
    protected $scene = [
        'local'   => ['storage', 'image_size', 'video_size', 'audio_size', 'word_size', 'other_size', 'limit_max'],
        'qiniu'   => ['storage', 'qiniu_access_key', 'qiniu_secret_key', 'qiniu_bucket', 'qiniu_domain', 'image_size', 'video_size', 'audio_size', 'word_size', 'other_size', 'limit_max'],
        'aliyun'  => ['storage', 'aliyun_access_key_id', 'aliyun_access_key_secret', 'aliyun_bucket', 'aliyun_endpoint',  'aliyun_bucket_domain', 'image_size', 'video_size', 'audio_size', 'word_size', 'other_size', 'limit_max'],
        'tencent' => ['storage', 'tencent_secret_id', 'tencent_secret_key', 'tencent_bucket', 'tencent_region', 'tencent_domain', 'image_size', 'video_size', 'audio_size', 'word_size', 'other_size', 'limit_max'],
        'baidu'   => ['storage', 'baidu_access_key', 'baidu_secret_key', 'baidu_bucket', 'baidu_endpoint', 'baidu_domain', 'image_size', 'video_size', 'audio_size', 'word_size', 'other_size', 'limit_max'],
        'upyun'   => ['storage', 'upyun_service_name', 'upyun_operator_name', 'upyun_operator_pwd', 'upyun_domain', 'image_size', 'video_size', 'audio_size', 'word_size', 'other_size', 'limit_max'],
        'aws'     => ['storage', 'aws_access_key_id', 'aws_secret_access_key', 'aws_bucket', 'aws_region', 'aws_domain', 'image_size', 'video_size', 'audio_size', 'word_size', 'other_size', 'limit_max'],
    ];
}
