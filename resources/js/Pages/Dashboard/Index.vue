<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import { ElCard } from 'element-plus';
import DashboardLayout from '@/DashboardLayouts/Dashboard.vue';
import 'element-plus/dist/index.css';

// Inertia.js
defineProps({
    isAdmin: Boolean,
    username: String,
    email: String,
})

</script>

<template>

    <Head title="主页" />

    <dashboard-layout>
        <template #title>
            Mewwoof 统一身份认证
        </template>
        <template #content>
            <el-card class="box-card">
                欢迎您！
                <span v-if="isAdmin">管理员 </span>
                <span v-else>用户 </span>
                {{ $page.props.userName }}
            </el-card>
            
        </template>
    </dashboard-layout>

</template>