import React from 'react';
import { AppShell } from '@/components/app-shell';
import { Button } from '@/components/ui/button';
import { router } from '@inertiajs/react';

interface Props {
    count: number;
    [key: string]: unknown;
}

export default function Counter({ count }: Props) {
    const handleIncrement = () => {
        router.post(route('counter.store'), {}, {
            preserveState: true,
            preserveScroll: true
        });
    };

    return (
        <AppShell>
            <div className="flex items-center justify-center min-h-[60vh]">
                <div className="text-center p-8 bg-white rounded-lg shadow-lg border">
                    <h1 className="text-6xl font-bold text-gray-800 mb-6">
                        {count}
                    </h1>
                    <p className="text-gray-600 mb-8 text-lg">
                        Counter Value
                    </p>
                    <Button 
                        onClick={handleIncrement}
                        size="lg"
                        className="px-8 py-3 text-lg"
                    >
                        Increment
                    </Button>
                </div>
            </div>
        </AppShell>
    );
}