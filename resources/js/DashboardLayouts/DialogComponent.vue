<template>
    <el-dialog :show-close="true">
        <template #header="{ close, titleId, titleClass }">
            <div class="my-header" style="display: flex; flex-direction: row; justify-content: space-between;">
                <h4 :id="titleId" :class="titleClass">{{ title }}</h4>
                <!-- <el-button type="danger" @click="close" round>
                    <el-icon class="el-icon--left">
                        <CircleCloseFilled />
                    </el-icon>
                    取消
                </el-button> -->
            </div>
        </template>
        <slot></slot>
    </el-dialog>
</template>

<script setup>
import { ElButton, ElIcon, ElDialog } from 'element-plus';
import {
    CircleCloseFilled
} from '@element-plus/icons-vue';
</script>

<script>
export default {
    props: ["model", "title"]
}
</script>