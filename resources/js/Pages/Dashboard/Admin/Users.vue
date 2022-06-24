<script setup>
import { ref, reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head } from '@inertiajs/inertia-vue3';
import {
    ElForm, ElFormItem, ElInput, ElSwitch, ElButton, ElIcon, ElTable, ElTableColumn, ElMessage
} from 'element-plus';
import {
    Plus, Edit, Lock, Delete
} from '@element-plus/icons-vue';
import axios from 'axios';
import DashboardLayout from '@/DashboardLayouts/Dashboard.vue';
import PanelSettingsComponent from '@/DashboardLayouts/PanelSettingsComponent.vue';
import DialogComponent from '@/DashboardLayouts/DialogComponent.vue';
import 'element-plus/dist/index.css';

// Form common
const labelPosition = ref('right');

const editUserDialogVisable = ref(false);
const editUserDialogTitle = ref('编辑用户');
const is_create_user = ref(false);

const formEditUser = reactive({
    id: Int32Array,
    name: String,
    email: String,
    password: String,
    verified: Boolean,
    admin: Boolean,
    enabled: Boolean,
    comment: String,
});

const handleCreateUser = () => {
    editUserDialogTitle.value = '创建用户';
    is_create_user.value = true;
    formEditUser.id = '';
    formEditUser.name = '';
    formEditUser.email = '';
    formEditUser.password = '';
    formEditUser.verified = false;
    formEditUser.admin = false;
    formEditUser.enabled = true;
    formEditUser.comment = '';
    editUserDialogVisable.value = true;
}

const handleUpdateUser = (row) => {
    editUserDialogTitle.value = '修改用户';
    is_create_user.value = false;
    formEditUser.id = row.id;
    formEditUser.name = row.name;
    formEditUser.email = row.email;
    formEditUser.password = '';
    formEditUser.verified = Boolean(row.email_verified_at);
    formEditUser.admin = Boolean(row.admin);
    formEditUser.enabled = Boolean(row.enabled);
    formEditUser.comment = row.comment;
    editUserDialogVisable.value = true;
}

const handleUserDialog = () => {
    var route_name;
    if (is_create_user.value == true) {
        route_name = 'dashboard_user_add';
    } else {
        route_name = 'dashboard_user_update';
    }
    postData(route_name, formEditUser);
}

const handleDeleteOrEnableClient = (row, route) => {
    postData(route, {id: row.id});
}

const postData = (route_name, form) => {
    axios.post(route(route_name), form)
        .then((response) => {

            if (response.data.status == 'success') {
                ElMessage({
                    type: 'success',
                    message: '操作成功',
                })
            Inertia.reload({ only: ['users'] })
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

    <Head title="用户管理" />

    <dashboard-layout>
        <template #title>
            用户管理
        </template>

        <template #content>

            <panel-settings-component>
                <template #title>用户列表</template>
                <template #content>
                    <el-button type="primary" @click="handleCreateUser">
                        <el-icon><Plus /></el-icon>
                        新增用户
                    </el-button>
                    <el-table :data="$page.props.users" style="width: 100%" table-layout="auto">
                        <el-table-column fixed prop="id" label="ID" />
                        <el-table-column prop="name" label="Name" width="60" />
                        <el-table-column prop="email" label="E-mail" />
                        <el-table-column prop="email_verified_at" label="Verified" />
                        <el-table-column prop="admin" label="Admin" />
                        <el-table-column prop="enabled" label="Enable" />
                        <el-table-column prop="comment" label="Comment" />

                        <el-table-column fixed="right" label="Operations" width="120">
                            <template #default="{ row }">
                                <el-button link type="primary" size="small"
                                    @click="handleUpdateUser(row)"><el-icon><Edit /></el-icon></el-button>
                                <el-button link type="warning" size="small"
                                    @click="handleDeleteOrEnableClient(row, 'dashboard_user_enable')"><el-icon><Lock /></el-icon></el-button>
                                <el-button link type="danger" size="small"
                                    @click="handleDeleteOrEnableClient(row, 'dashboard_user_delete')"><el-icon><Delete /></el-icon></el-button>
                            </template>
                        </el-table-column>
                    </el-table>
                </template>
            </panel-settings-component>


            <DialogComponent v-model="editUserDialogVisable" :title="editUserDialogTitle">
                <el-form :model="formEditUser" :label-position="labelPosition" label-width="120px">
                    <el-form-item label="用户ID">
                        <el-input v-model="formEditUser.id" :disabled="is_create_user"/>
                    </el-form-item>
                    <el-form-item label="用户名">
                        <el-input v-model="formEditUser.name" />
                    </el-form-item>
                    <el-form-item label="电子邮件">
                        <el-input v-model="formEditUser.email" type="email" />
                    </el-form-item>
                    <el-form-item label="密码">
                        <el-input v-model="formEditUser.password" type="password" placeholder="未更改" />
                    </el-form-item>
                    <el-form-item label="已认证">
                        <el-switch v-model="formEditUser.verified" />
                    </el-form-item>
                    <el-form-item label="管理员">
                        <el-switch v-model="formEditUser.admin" />
                    </el-form-item>
                    <el-form-item label="已启用">
                        <el-switch v-model="formEditUser.enabled" />
                    </el-form-item>
                    <el-form-item label="备注">
                        <el-input v-model="formEditUser.comment" />
                    </el-form-item>

                    <el-form-item>
                        <el-button type="primary" :icon="Check"
                            @click="handleUserDialog(formEditUser, 'dashboard_client_common_add')">确认</el-button>
                    </el-form-item>
                </el-form>

            </DialogComponent>

        </template>

    </dashboard-layout>

</template>