<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import { reactive, ref } from 'vue';
import { ElRow, ElCol, ElIcon, ElCard, ElButton, ElMessage } from 'element-plus';
import {
    Cellphone,
} from '@element-plus/icons-vue';
import uaParserJs from 'ua-parser-js';
import DashboardLayout from '@/DashboardLayouts/Dashboard.vue';
import 'element-plus/dist/index.css';
import PanelSettingsComponent from '@/DashboardLayouts/PanelSettingsComponent.vue';
import axios from 'axios';

// Inertia.js
defineProps({
    isAdmin: Boolean,
    username: String,
    email: String,
})

const handleSessionLogout = (id) => {
    axios.post(route('dashboard_session_delete'), {'id': id})
        .then((response) => {

            if (response.data.status == 'success') {
                ElMessage({
                    type: 'success',
                    message: '操作成功',
                })
            location.reload();
            }

        })
        .catch(function (error) {
            ElMessage({
                type: 'error',
                message: '操作失败',
            })

            console.log(error);
        });
}

</script>

<template>

    <Head title="会话" />

    <dashboard-layout>

        <template #title>
            会话管理
        </template>

        <template #content>

            <h2 style="font-size: var(--el-font-size-large)">
                最近会话
            </h2><br />
            <el-card v-for="(item, i) in $page.props.sessions" :name="item.id">
                <h2 style="font-size: var(--el-font-size-large)">
                    <el-icon>
                        <Cellphone />
                    </el-icon>&nbsp;&nbsp;
                    {{ uaParserJs(item.user_agent).os.name }}: 
                    {{ uaParserJs(item.user_agent).browser.name }} 
                    {{ uaParserJs(item.user_agent).browser.major }}
                </h2>
                <el-row justify="space-between">
                    <el-col :span="14">
                        IP: {{ item.ip_address }}<br />
                        上次活动: {{ (new Date(new Date().getTime() - item.last_activity * 1000)).toLocaleString() }}<br />
                    </el-col>
                    <el-col :span="6" style="text-align: right;">
                        <el-button type="danger" @click="handleSessionLogout(item.id)">登出</el-button>&nbsp;&nbsp;
                    </el-col>
                </el-row>
                
            </el-card>

        </template>

    </dashboard-layout>

</template>