import { useEffect } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import InputError from '@/Components/InputError';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';


export default function UserImport({ auth }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        file: ''
    });

    const submit = (e) => {
        e.preventDefault();

        post(route('users.save_import'));
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Funcionários - Importar</h2>}
        >
            <Head title="Funcionários - Importar" />

            <div className='flex'>
                <div className="py-6 flex-1">
                    <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div className="bg-blue-200 overflow-hidden shadow-sm sm:rounded-lg">
                            <div className="p-6 text-gray-900">
                                <form onSubmit={submit}>
                                    <div>
                                        <TextInput
                                            id="file"
                                            type="file"
                                            name="file"
                                            className="mt-1 block w-full"
                                            onChange={e => setData('file', e.target.files[0])}
                                        />

                                        <InputError message={errors.file} className="mt-2" />
                                    </div>

                                    <div className="flex items-center justify-end mt-4">
                                        <PrimaryButton className="ml-4" disabled={processing}>
                                            Enviar
                                        </PrimaryButton>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

           
            
        </AuthenticatedLayout>
    );
}
