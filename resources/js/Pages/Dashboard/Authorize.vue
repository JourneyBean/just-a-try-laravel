<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';
import { ElCard, ElIcon, ElButton, ElRow, ElCol, ElSwitch, ElMessage } from 'element-plus';
import {
    Cellphone,
} from '@element-plus/icons-vue'
import DashboardLayout from '@/DashboardLayouts/Dashboard.vue';
import 'element-plus/dist/index.css';
import PanelSettingsComponent from '@/DashboardLayouts/PanelSettingsComponent.vue';

// Inertia.js
defineProps({
    isAdmin: Boolean,
    username: String,
    email: String,
})

const handleTokenDelete = (id) => {
    axios.post(route('dashboard_token_delete'), {'id': id})
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

    <Head title="授权" />

    <dashboard-layout>

        <template #title>
            授权管理
        </template>

        <template #content>

            <h2 style="font-size: var(--el-font-size-large)">
                已授权的应用
            </h2><br />
            <el-card v-for="(item, i) in $page.props.tokens" :name="item.id">
                <h2 style="font-size: var(--el-font-size-large)">
                    <el-icon>
                        <Cellphone />
                    </el-icon>&nbsp;&nbsp;
                    {{ item.client_name }}
                </h2>
                <el-row justify="space-between">
                    <el-col :span="14">
                        授权时间: {{ item.created_at }}<br />
                        到期: {{ ((new Date(item.expires_at)).getTime() > (new Date().getTime())) ? '否' : '是' }}<br />
                    </el-col>
                    <el-col :span="10" style="text-align: right;">
                        <!-- <el-switch v-model="tokenEnabled[item.id]" inline-prompt active-text="启用" inactive-text="停用" @change="handleToken('dashboard_token_revoke')"/> -->
                        <el-button type="danger" @click="handleTokenDelete(item.id)">删除</el-button>&nbsp;&nbsp;
                    </el-col>
                </el-row>
                <div>

                </div>
            </el-card>

        </template>

    </dashboard-layout>

</template>