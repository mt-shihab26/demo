<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/components/ui/tooltip';
import { Bell } from 'lucide-vue-next';

const disabled = false;
const badge = false;
</script>

<template>
    <TooltipProvider :delay-duration="0">
        <Tooltip>
            <TooltipTrigger>
                <Button variant="ghost" size="icon" class="group relative h-9 w-9 cursor-pointer" :disabled="disabled">
                    <Bell class="size-5 opacity-80 group-hover:opacity-100" />
                    <span v-if="badge" class="absolute -top-0 -right-0 flex h-3 w-3">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex h-3 w-3 rounded-full bg-red-500"></span>
                    </span>
                </Button>
            </TooltipTrigger>
            <TooltipContent>
                <p>Notifications</p>
            </TooltipContent>
        </Tooltip>
    </TooltipProvider>
</template>
