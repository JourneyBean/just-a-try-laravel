<script setup>
import { reactive, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head } from '@inertiajs/inertia-vue3';
import {
    ElButton, ElTable, ElTableColumn, ElDropdown, ElDropdownItem, ElDropdownMenu, ElIcon, ElForm, ElFormItem, ElInput, ElMessage, ElMessageBox
} from 'element-plus';
import {
    ArrowDown, Lock, Delete
} from '@element-plus/icons-vue';
import axios from 'axios';
import DashboardLayout from '@/DashboardLayouts/Dashboard.vue';
import PanelSettingsComponent from '@/DashboardLayouts/PanelSettingsComponent.vue';
import DialogComponent from '@/DashboardLayouts/DialogComponent.vue';
import 'element-plus/dist/index.css';

// Inertia.js
defineProps({
    isAdmin: Boolean,
    username: String,
    email: String,
})

const addCommonClientDialogVisible = ref(false);
const addPublicClientDialogVisible = ref(false);
const addPasswordClientDialogVisible = ref(false);
const addClientClientDialogVisible = ref(false);
const addPersonalClientDialogVisible = ref(false);

const handleAddClient = (command) => {
    switch (command) {
        case 'common':
            addCommonClientDialogVisible.value = true;
            break;

        case 'public':
            addPublicClientDialogVisible.value = true;
            break;

        case 'password':
            addPasswordClientDialogVisible.value = true;
            break;

        case 'client':
            addClientClientDialogVisible.value = true;
            break;

        case 'personal':
            addPersonalClientDialogVisible.value = true;
            break;

        default:
            break;
    }
}

const handleClient = (row, route_name) => {
    console.log(row);
    axios.post(route(route_name), {
        client_id: row.id
    })
        .then((response) => {

            if (response.data.status == 'success') {
                ElMessage({
                    type: 'success',
                    message: '操作成功',
                })
                Inertia.reload({ only: ['clients'] })
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

// Form common
const labelPosition = ref('right');

// Add client form
const formAddCommonClient = reactive({
    name: '',
    user_id: '',
    redirect: '',
});
const formAddPublicClient = reactive({
    name: '',
    user_id: '',
    redirect: '',
});
const formAddPasswordClient = reactive({
    name: '',
    provider: '',
});
const formAddClientClient = reactive({
    name: '',
});
const formAddPersonalClient = reactive({
    name: '',
});
const submitClient = (form, route_name) => {
    axios.post(route(route_name), form)
        .then((response) => {

            if (response.data.created_client_status == 'success') {
                ElMessage({
                    type: 'success',
                    message: '操作成功',
                })

                ElMessageBox.alert("请记好客户端密钥，仅显示一次：\n客户端ID: " + response.data.created_client_id + "\n客户端密钥: " + response.data.created_client_secret, '成功', {
                    confirmButtonText: 'OK',
                    callback: (action) => {
                        addCommonClientDialogVisible.value = false;
                        addPublicClientDialogVisible.value = false;
                        addPasswordClientDialogVisible.value = false;
                        addClientClientDialogVisible.value = false;
                        addPersonalClientDialogVisible.value = false;
                        Inertia.reload({ only: ['clients'] })
                    },
                })

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

    <Head title="客户端管理" />

    <dashboard-layout>
        <template #title>
            OAuth客户端管理
        </template>

        <template #content>

            <panel-settings-component>
                <template #title>添加客户端</template>
                <template #content>

                    <el-dropdown @command="handleAddClient" trigger="click">
                        <el-button type="primary">
                            添加客户端
                            <el-icon class="el-icon--right">
                                <arrow-down />
                            </el-icon>
                        </el-button>
                        <template #dropdown>
                            <el-dropdown-menu>
                                <el-dropdown-item command="common">普通客户端</el-dropdown-item>
                                <el-dropdown-item command="public">公共客户端 (PCKE) </el-dropdown-item>
                                <el-dropdown-item command="password">密码客户端 (不建议)</el-dropdown-item>
                                <el-dropdown-item command="client">机器访问客户端</el-dropdown-item>
                                <el-dropdown-item command="personal">个人访问客户端</el-dropdown-item>
                            </el-dropdown-menu>
                        </template>
                    </el-dropdown>

                </template>
            </panel-settings-component>

            <panel-settings-component>
                <template #title>客户端列表</template>
                <template #content>
                    <el-table :data="$page.props.clients" style="width: 100%" table-layout="auto">
                        <el-table-column fixed prop="name" label="Name" />
                        <el-table-column prop="user_id" label="User" width="60" />
                        <el-table-column prop="id" label="UUID" />
                        <el-table-column prop="redirect" label="Redirect" />
                        <el-table-column prop="password_client" label="Password" width="60" />
                        <el-table-column prop="provider" label="Provider" width="60" />
                        <el-table-column prop="personal_access_client" label="Personal" width="60" />
                        <el-table-column prop="revoked" label="Revoked" width="60" />
                        <el-table-column fixed="right" label="Operations" width="120">
                            <template #default="{ row }">
                                <el-button link type="warning" size="small"
                                    @click="handleClient(row, 'dashboard_client_revoke')"><el-icon><Lock /></el-icon></el-button>
                                <el-button link type="danger" size="small"
                                    @click="handleClient(row, 'dashboard_client_delete')"><el-icon><Delete /></el-icon></el-button>
                            </template>
                        </el-table-column>
                    </el-table>
                </template>
            </panel-settings-component>

            <!-- Dialogs -->

            <!-- <DialogComponent v-model="createdClientDialogVisible" title="成功">
                <span>
                    请妥善保管以下信息，密钥仅显示一次<br />
                    客户端ID: {{ ref('created_client_id') }}<br />
                    客户端密钥: {{ ref('created_client_secret') }}
                </span>
            </DialogComponent> -->

            <DialogComponent v-model="addCommonClientDialogVisible" title="添加普通客户端">

                <el-form :model="formAddCommonClient" :label-position="labelPosition" label-width="120px">

                    <el-form-item label="名称">
                        <el-input v-model="formAddCommonClient.name" :placeholder="`请输入客户端名称`" />
                    </el-form-item>

                    <el-form-item label="所属用户">
                        <el-input v-model="formAddCommonClient.user_id" :placeholder="`请输入用户ID`" />
                    </el-form-item>

                    <el-form-item label="回调地址">
                        <el-input v-model="formAddCommonClient.redirect" :placeholder="`请输入客户端回调地址`" />
                    </el-form-item>

                    <el-form-item>
                        <el-button type="primary" :icon="Check"
                            @click="submitClient(formAddCommonClient, 'dashboard_client_common_add')">确认</el-button>
                    </el-form-item>

                </el-form>

            </DialogComponent>

            <DialogComponent v-model="addPublicClientDialogVisible" title="添加公共客户端(PCKE)">

                <el-form :model="formAddPublicClient" :label-position="labelPosition" label-width="120px">

                    <el-form-item label="名称">
                        <el-input v-model="formAddPublicClient.name" :placeholder="`请输入客户端名称`" />
                    </el-form-item>

                    <el-form-item label="所属用户">
                        <el-input v-model="formAddPublicClient.user_id" :placeholder="`请输入用户ID`" />
                    </el-form-item>

                    <el-form-item label="回调地址">
                        <el-input v-model="formAddPublicClient.redirect" :placeholder="`请输入客户端回调地址`" />
                    </el-form-item>

                    <el-form-item>
                        <el-button type="primary" :icon="Check"
                            @click="submitClient(formAddPublicClient, 'dashboard_client_public_add')">确认</el-button>
                    </el-form-item>

                </el-form>

            </DialogComponent>

            <DialogComponent v-model="addPasswordClientDialogVisible" title="添加密码客户端(不建议)">

                <el-form :model="formAddPasswordClient" :label-position="labelPosition" label-width="120px">

                    <el-form-item label="名称">
                        <el-input v-model="formAddPasswordClient.name" :placeholder="`请输入客户端名称`" />
                    </el-form-item>

                    <el-form-item label="用户数据库">
                        <el-input v-model="formAddPasswordClient.user_id" :placeholder="`请输入用户数据库`" />
                    </el-form-item>

                    <el-form-item>
                        <el-button type="primary" :icon="Check"
                            @click="submitClient(formAddPasswordClient, 'dashboard_client_password_add')">确认</el-button>
                    </el-form-item>

                </el-form>

            </DialogComponent>

            <DialogComponent v-model="addClientClientDialogVisible" title="添加机器访问客户端">

                <el-form :model="formAddClientClient" :label-position="labelPosition" label-width="120px">

                    <el-form-item label="名称">
                        <el-input v-model="formAddClientClient.name" :placeholder="`请输入客户端名称`" />
                    </el-form-item>

                    <el-form-item>
                        <el-button type="primary" :icon="Check"
                            @click="submitClient(formAddClientClient, 'dashboard_client_client_add')">确认</el-button>
                    </el-form-item>

                </el-form>

            </DialogComponent>

            <DialogComponent v-model="addPersonalClientDialogVisible" title="添加个人访问客户端">

                <el-form :model="formAddPersonalClient" :label-position="labelPosition" label-width="120px">

                    <el-form-item label="名称">
                        <el-input v-model="formAddPersonalClient.name" :placeholder="`请输入客户端名称`" />
                    </el-form-item>

                    <el-form-item>
                        <el-button type="primary" :icon="Check"
                            @click="submitClient(formAddPersonalClient, 'dashboard_client_personal_add')">确认</el-button>
                    </el-form-item>

                </el-form>

            </DialogComponent>

        </template>

    </dashboard-layout>

</template>