<?php

[$newsEdit, $newsView] = ViewComponent::importMolecules(['newsEdit', 'newsView']);
[$breadcrumb, $userInfo] = ViewComponent::importMolecules(['breadcrumb', 'userInfo']);

$newsDetail = new PageComponent(
    props: $_PROPS,
    mounted: function(object &$values, array $props) {
        $values->userInfoProps = [
            'title' => 'ユーザー',
            'id' => $props['id'],
            'username' => $props['name'],
            'postsCount' => $props['postsCount'],
        ];
    },
    propTypes: ['id' => 'string', 'name' => 'string', 'postsCount' => 'integer']
);

?>

<aside class="w-full lg:w-80 m-3">
    <?=$userInfo->view($newsDetail->rawValues->userInfoProps)?>
</aside>
