<script setup>
import { ElDivider } from 'element-plus';

</script>

<template>
    <h1 style="font-size: var(--el-font-size-extra-large)">
        <slot name="title"></slot>
    </h1>
    <el-divider />
    <slot name="content"></slot>
</template>
