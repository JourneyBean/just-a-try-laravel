<script setup>
import { ElContainer, ElHeader, ElAside, ElMain, ElFooter } from 'element-plus';
import HeaderContent from '@/DashboardLayouts/HeaderContent.vue';
import AsideContent from '@/DashboardLayouts/AsideContent.vue';
import MainContent from '@/DashboardLayouts/MainContent.vue';
import FooterContent from '@/DashboardLayouts/FooterContent.vue';
// import BreadcrumbContent from '@/DashboardLayouts/BreadcrumbContent.vue';

</script>

<style>
.main_div_wrap {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.main_container {
    height: 100%;
}
</style>

<template>

    <div class="main_div_wrap">
        <el-container class="main_container">
            <el-header>
                <HeaderContent />
            </el-header>
            <el-container>
                <el-aside>
                    <AsideContent />
                </el-aside>
                <el-container>
                    <el-main>
                        <MainContent>
                            <template #title>
                                <slot name="title"></slot>
                            </template>
                            <template #content>
                                <slot name="content"></slot>
                            </template>
                        </MainContent>
                    </el-main>
                    <el-footer>
                        <FooterContent />
                    </el-footer>
                </el-container>
            </el-container>
        </el-container>
    </div>

</template>