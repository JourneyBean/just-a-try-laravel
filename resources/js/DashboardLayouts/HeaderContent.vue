<template>
    <div class="header_wrap">
        <el-menu :default-active="null" class="el-menu-demo" mode="horizontal" :ellipsis="false">

            <el-menu-item index="header_logo">Dashboard</el-menu-item>
            <div class="flex-grow" />

            <el-sub-menu index="menu_username">
                <template #title>{{ $page.props.userName }}</template>

                <!-- <el-menu-item index="menu_logout" @click="handleLogout" :route="'/' + $page.props.ziggy.routes.logout.uri">退出登录</el-menu-item> -->
                <el-menu-item index="menu_logout" @click="handleLogout">退出登录</el-menu-item>

            </el-sub-menu>
        </el-menu>

    </div>
</template>

<script setup>
import { ElMenu, ElMenuItem, ElSubMenu } from 'element-plus';
import { Inertia } from '@inertiajs/inertia';
const handleLogout = () => {
    Inertia.post(route('logout'));
}

</script>

<style>
</style>