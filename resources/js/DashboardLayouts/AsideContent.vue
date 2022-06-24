<template>

    <div class="aside_menu_wrap">

        <el-menu :default-active="$page.props.dashboardIndexName" class="el-menu-vertical-demo">

            <el-menu-item index="dashboard_index"
                @click="openLink($page.props.ziggy.routes.dashboard_index.uri)">
                <el-icon>
                    <collection-tag />
                </el-icon>
                <span>主页</span>
            </el-menu-item>

            <el-menu-item index="dashboard_account"
                @click="openLink($page.props.ziggy.routes.dashboard_account.uri)">
                <el-icon>
                    <user />
                </el-icon>
                <span>账户</span>
            </el-menu-item>

            <el-menu-item index="dashboard_authenticate"
                @click="openLink($page.props.ziggy.routes.dashboard_authenticate.uri)">
                <el-icon>
                    <key />
                </el-icon>
                <span>认证</span>
            </el-menu-item>

            <el-menu-item index="dashboard_authorize"
                @click="openLink($page.props.ziggy.routes.dashboard_authorize.uri)">
                <el-icon>
                    <lock />
                </el-icon>
                <span>授权</span>
            </el-menu-item>

            <el-menu-item index="dashboard_sessions"
                @click="openLink($page.props.ziggy.routes.dashboard_sessions.uri)">
                <el-icon>
                    <chat-square />
                </el-icon>
                <span>会话</span>
            </el-menu-item>

            <el-sub-menu index="dashboard_admin" v-if="$page.props.isAdmin">
                <template #title>
                    <el-icon><setting /></el-icon>
                    <span>管理</span>
                </template>

                <el-menu-item index="dashboard_admin_clients"
                    @click="openLink($page.props.ziggy.routes.dashboard_admin_clients.uri)">
                    <el-icon><notebook /></el-icon>
                    <span>OAuth客户端</span>
                </el-menu-item>

                <el-menu-item index="dashboard_admin_users"
                    @click="openLink($page.props.ziggy.routes.dashboard_admin_users.uri)">
                    <el-icon><notebook /></el-icon>
                    <span>用户</span>
                </el-menu-item>
            </el-sub-menu>

        </el-menu>

    </div>
</template>

<script setup>
import {
    CollectionTag,
    Document,
    Key,
    Lock,
    Aim,
    ChatSquare,
    Link as IconLink,
    Menu as IconMenu,
    User,
    Setting,
    Notebook
} from '@element-plus/icons-vue'
import { ElIcon, ElMenu, ElMenuItem, ElMenuItemGroup, ElSubMenu, ElCol, ElRow } from 'element-plus'
import openLink from '@/DashboardLibs/OpenLink.js';

// Inertia.js
defineProps({
    currentIndex: String,
})

</script>

<style>
</style>