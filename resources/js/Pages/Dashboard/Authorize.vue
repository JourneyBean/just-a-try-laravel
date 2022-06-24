<script setup>
import { Head } from '@inertiajs/inertia-vue3';
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
import 'element-plus/dist/index.css';
import PanelSettingsComponent from '@/DashboardLayouts/PanelSettingsComponent.vue';

// Inertia.js
defineProps({
    isAdmin: Boolean,
    username: String,
    email: String,
})

const labelPosition = ref('right')

</script>

<template>

    <Head title="授权" />

    <dashboard-layout>

        <template #title>
            授权管理
        </template>

        <template #content>

            <PanelSettingsComponent>
                <template #title>已授权</template>
            </PanelSettingsComponent>

        </template>

    </dashboard-layout>

</template>