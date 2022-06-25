<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import { reactive, ref } from 'vue';
import { ElForm, ElFormItem, ElInput, ElButton, ElMessage } from 'element-plus';
import {
    Check,
} from '@element-plus/icons-vue'
import DashboardLayout from '@/DashboardLayouts/Dashboard.vue';
import PanelSettingsComponent from '@/DashboardLayouts/PanelSettingsComponent.vue';
import 'element-plus/dist/index.css';
import axios from 'axios';

// Inertia.js
defineProps({
    isAdmin: Boolean,
    username: String,
    email: String,
})

const labelPosition = ref('right')

const formResetPassword = reactive({
    old_password: '',
    password: '',
    password_confirmation: '',
});

const handleResetPassword = () => {
    axios.post(route('dashboard_authenticate_resetPassword'), formResetPassword)
        .then((response) => {
            if (response.data.status == 'success') {
                ElMessage({
                    type: 'success',
                    message: '操作成功'
                })
            } else {
                ElMessage({
                    type: 'error',
                    message: '操作失败',
                })
            }
        })
        .catch(function (error) {
            ElMessage({
                type: 'error',
                message: '操作失败',
            })
        });
};

</script>

<template>

    <Head title="认证" />

    <dashboard-layout>

        <template #title>
            认证设置
        </template>

        <template #content>

            <panel-settings-component>
                <template #title>重置密码</template>
                <template #content>
                    <el-form :model="formResetPassword" :label-position="labelPosition" :inline="true"
                        label-width="100px" style="max-width: 500px">

                        <el-form-item label="旧密码">
                            <el-input type="password" v-model="formResetPassword.old_password" />
                        </el-form-item>
                        <el-form-item label="新密码">
                            <el-input type="password" v-model="formResetPassword.password" />
                        </el-form-item>
                        <el-form-item label="确认新密码">
                            <el-input type="password" v-model="formResetPassword.password_confirmation" />
                        </el-form-item>

                        <el-form-item>
                            <el-button type="primary" :icon="Check" @click="handleResetPassword">重置密码</el-button>
                        </el-form-item>

                    </el-form>
                </template>
            </panel-settings-component>

        </template>

    </dashboard-layout>

</template>