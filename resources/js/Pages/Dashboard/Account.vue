<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';
import { ElDivider, ElCard, ElForm, ElFormItem, ElInput, ElButton, ElSpace } from 'element-plus';
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

const labelPosition = ref('right')
const inputUserEmail = ref('')

</script>

<template>

    <Head title="账户" />

    <dashboard-layout>
        <template #title>
            我的账户
        </template>

        <template #content>

            <panel-settings-component>
                <template #title>电子邮件</template>
                <template #content>
                    <el-form :label-position="labelPosition" :inline="true" ref="changeEmailRef" label-width="100px"
                        style="max-width: 500px">

                        <el-form-item label="更改电子邮件">
                            <el-input v-model="inputUserEmail" :placeholder="$page.props.userEmail" clearable disabled="true" />
                        </el-form-item>

                        <el-form-item>
                            <el-button type="primary" @click="submitForm(changeEmailRef)" :icon="Check" :disabled="true"
                                circle />
                        </el-form-item>

                    </el-form>
                </template>
            </panel-settings-component>

            <panel-settings-component>
                <template #title>导出账户数据</template>
                <template #content>
                    <el-form :label-position="labelPosition" :inline="true" ref="changeEmailRef" label-width="100px"
                        style="max-width: 500px">

                        <el-form-item>
                            <el-button type="primary" @click="submitForm(changeEmailRef)" :icon="Delete">
                                导出账户
                            </el-button>
                        </el-form-item>

                    </el-form>
                </template>
            </panel-settings-component>

            <panel-settings-component>
                <template #title>删除账户</template>
                <template #content>
                    <el-form :label-position="labelPosition" :inline="true" ref="changeEmailRef" label-width="100px"
                        style="max-width: 500px">

                        <el-form-item>
                            <el-button type="danger" @click="submitForm(changeEmailRef)" :icon="Delete">
                                删除账户
                            </el-button>
                        </el-form-item>

                    </el-form>
                </template>
            </panel-settings-component>

        </template>

    </dashboard-layout>

</template>