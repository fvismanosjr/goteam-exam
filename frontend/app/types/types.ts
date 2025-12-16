export interface UserType {
    id: number,
    name: string,
    email: string,
    avatar: string,
}

export interface TaskType {
    id: number,
    user_id: number,
    created_at: string,
    updated_at: string,
    deleted_at: string,
    active?: boolean,
}

export interface TaskResponseType {
    tasks: TaskType[]
}

export interface TaskItemType {
    id: number,
    task_id: number,
    description: string,
    priority: number,
    is_done: number,
    created_at: string,
    updated_at: string,
    deleted_at: string,
}

export interface TaskItemResponseType {
    taskItems: TaskItemType[]
}