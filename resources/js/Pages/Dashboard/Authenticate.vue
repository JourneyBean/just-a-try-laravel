<script setup>
import { Head, useForm } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';
import { ElDivider, ElCard, ElForm, ElFormItem, ElInput, ElButton } from 'element-plus';
import {
    Check,
    Delete,
    Edit,
    Message,
    Search,
    Star,
} from '@element-plus/icons-vue'
import DashboardLayout from '@/DashboardLayouts/Dashboard.vue';
import PanelSettingsComponent from '@/DashboardLayouts/PanelSettingsComponent.vue';
import 'element-plus/dist/index.css';

// Inertia.js
defineProps({
    isAdmin: Boolean,
    username: String,
    email: String,
})

const formResetPassword = useForm({
    email: '',
});

const submit = () => {
    formResetPassword.post(route('password.email'));
};

const labelPosition = ref('right')
const input = ref('')

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
                    <el-form :label-position="labelPosition" :inline="true" ref="changeEmailRef" label-width="100px"
                        style="max-width: 500px" @submit.prevent="submit">

                        <el-form-item label="当前邮箱">
                            <el-input id="email" :type="email" v-model="formResetPassword.email" :placeholder="$page.props.userEmail" disabled />
                        </el-form-item>

                        <el-form-item>
                            <el-button native-type="submit" type="primary" :icon="Check" :disabled="formResetPassword.processing" :class="{'opacity-25': formResetPassword.processing}">发送重置邮件</el-button>
                        </el-form-item>

                    </el-form>
                </template>
            </panel-settings-component>

        </template>

    </dashboard-layout>

</template>