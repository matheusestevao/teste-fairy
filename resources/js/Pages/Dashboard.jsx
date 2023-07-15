import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

export default function Dashboard({ auth, veteram_employee, average_salary }) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>}
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">Ola, {auth.user.name}</div>
                    </div>
                </div>
            </div>

            <div className='flex'>
                {veteram_employee && (
                    <>
                        <div className="py-6 flex-1">
                            <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                <div className="bg-blue-200 overflow-hidden shadow-sm sm:rounded-lg">
                                    <div className="p-6 text-gray-900">
                                        <h2 className="text-xl font-bold mb-4">Mais tempo de Empresa</h2>
                                        <p className="text-gray-700">
                                            {veteram_employee.name} - com {veteram_employee.time_service} <small>(dias)</small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </>
                )}

                <div className="py-6 flex-1">
                    <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div className="bg-green-200 overflow-hidden shadow-sm sm:rounded-lg">
                            <div className="p-6 text-gray-900">
                                <h2 className="text-xl font-bold mb-4">Média Salarial por Cargo</h2>
                                {average_salary.length > 0 ? (
                                    <ul className="list-disc ml-6">
                                        {average_salary.map((item, index) => (
                                            <li key={index}>{item.profission}: R$ {parseFloat(item.average_salary).toFixed(2)}</li>
                                        ))}
                                    </ul>
                                ) : (
                                    <p>Sem informações até o momento.</p>
                                )}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
        </AuthenticatedLayout>
    );
}
