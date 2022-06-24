<script setup>
import { ElCard } from 'element-plus';
</script>

<template>
    <h2 style="font-size: var(--el-font-size-large)">
        <slot name="title"></slot>
    </h2><br />
    <el-card class="box-card">
        <slot name="content"></slot>
    </el-card><br />
</template>
