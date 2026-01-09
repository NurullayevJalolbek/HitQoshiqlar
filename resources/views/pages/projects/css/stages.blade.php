/* =================== STAGES TIMELINE STYLES =================== */

/* Progress Section */
.progress-section {
  margin: 1rem 0 1.5rem 0;
  padding: 0;
}

.progress-bar-wrapper {
  position: relative;
  height: 56px;
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  border-radius: 28px;
  overflow: hidden;
  box-shadow: inset 0 2px 4px rgba(0,0,0,0.06);
}

.progress-bar-fill {
  position: absolute;
  left: 0;
  top: 0;
  height: 100%;
  background: linear-gradient(90deg, #10b981 0%, #059669 100%);
  transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
  box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
}

.progress-bar-label {
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
  display: flex;
  align-items: center;
  gap: 0.625rem;
  font-weight: 600;
  font-size: 1.125rem;
  color: #1f2937;
  z-index: 2;
  text-shadow: 0 1px 2px rgba(255,255,255,0.8);
}

#progressIcon {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
  background: white;
  border-radius: 50%;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  color: #059669;
}

#progressIcon svg,
#progressIcon img.stage-icon-img {
  width: 28px;
  height: 28px;
  object-fit: contain;
}

/* Timeline Styles */
.stage-timeline {
  margin: 1.5rem 0 0 0;
  padding: 0;
}

.stage-item {
  display: flex;
  gap: 1rem;
  padding: 0;
  margin: 0 0 1.5rem 0;
  position: relative;
  transition: all 0.3s ease;
}

.stage-item:last-child {
  margin-bottom: 0;
}

/* Marker Column */
.stage-marker-wrap {
  display: flex;
  flex-direction: column;
  align-items: center;
  flex-shrink: 0;
  width: 80px;
  position: relative;
}

.stage-marker {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
  border: 4px solid #d1d5db;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #6b7280;
  transition: all 0.3s ease;
  position: relative;
  z-index: 2;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.stage-marker::before {
  content: '';
  position: absolute;
  width: 100%;
  height: 100%;
  background: white;
  border-radius: 50%;
  z-index: -1;
}

.stage-marker svg,
.stage-marker img.stage-icon-img {
  width: 48px;
  height: 48px;
  object-fit: contain;
  transition: all 0.3s ease;
}

/* Active Stage */
.stage-item.active .stage-marker {
  background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
  border-color: #f59e0b;
  color: #f59e0b;
  box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
  animation: pulse 2s infinite;
}

@keyframes pulse {
  0%, 100% {
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
  }
  50% {
    box-shadow: 0 4px 20px rgba(245, 158, 11, 0.5);
  }
}

/* Completed Stage */
.stage-item.completed .stage-marker {
  background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
  border-color: #10b981;
  color: #059669;
  box-shadow: 0 2px 8px rgba(16, 185, 129, 0.2);
}

/* Connecting Line */
.stage-line {
  position: absolute;
  width: 4px;
  top: 80px;
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  background: #e5e7eb;
  transition: background 0.3s ease;
  z-index: 1;
  height: calc(100% + 1.5rem);
}

.stage-item:last-child .stage-line {
  display: none;
}

.stage-item.completed .stage-line {
  background: #10b981;
}

.stage-item.active .stage-line {
  background: linear-gradient(to bottom, #10b981 0%, #e5e7eb 100%);
}

/* Content Section */
.stage-content {
  flex: 1;
  padding: 0.5rem 0;
  min-height: 80px;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.stage-title {
  font-size: 1.125rem;
  font-weight: 600;
  color: #1f2937;
  margin: 0 0 0.5rem 0;
  line-height: 1.5;
}

.stage-item.active .stage-title {
  color: #f59e0b;
}

.stage-item.completed .stage-title {
  color: #059669;
}

.stage-dates {
  font-size: 1rem;
  color: #6b7280;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  flex-wrap: wrap;
  margin: 0;
  line-height: 1.6;
}

.stage-duration {
  padding: 0.25rem 0.625rem;
  background: #f3f4f6;
  border-radius: 14px;
  font-size: 0.875rem;
  font-weight: 500;
  color: #6b7280;
  margin: 0;
}

.stage-item.active .stage-duration {
  background: #fef3c7;
  color: #f59e0b;
}

.stage-item.completed .stage-duration {
  background: #d1fae5;
  color: #059669;
}

/* Edit Mode Styles */
.stage-item.dragging {
  opacity: 0.5;
  cursor: grabbing !important;
}

.stage-item.drag-over {
  background: rgba(59, 130, 246, 0.05);
  border-radius: 8px;
}

.stage-item[draggable="true"] {
  cursor: move;
}

.stage-edit-actions {
  display: flex;
  gap: 0.5rem;
  margin-top: 0.5rem;
}

.stage-edit-actions .btn {
  font-size: 0.875rem;
  padding: 0.25rem 0.75rem;
}

/* Tab Header Actions */
.tab-header-actions {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  flex-wrap: wrap;
  margin: 0;
  padding: 0;
}

.drop-hint {
  font-size: 0.875rem;
  color: #6b7280;
  display: none;
  margin: 0;
}

.drop-hint.show {
  display: flex;
  align-items: center;
  gap: 0.25rem;
}

#stagesTools {
  display: none;
}

#stagesTools.show {
  display: flex;
}

/* Responsive */
@media (max-width: 768px) {
  .progress-section {
    margin: 0.75rem 0 1rem 0;
  }
  
  .stage-timeline {
    margin: 1rem 0 0 0;
  }
  
  .stage-item {
    gap: 0.75rem;
    margin-bottom: 1.25rem;
  }
  
  .stage-marker-wrap {
    width: 48px;
  }
  
  .stage-marker {
    width: 48px;
    height: 48px;
  }
  
  .stage-marker svg,
  .stage-marker img.stage-icon-img {
    width: 30px;
    height: 30px;
  }
  
  .stage-line {
    top: 48px;
    height: calc(100% + 1.25rem);
  }
  
  .stage-content {
    min-height: 48px;
    padding: 0.25rem 0;
  }
  
  .stage-title {
    font-size: 0.9375rem;
    margin-bottom: 0.25rem;
  }
  
  .stage-dates {
    font-size: 0.8125rem;
  }
  
  .progress-bar-wrapper {
    height: 40px;
  }
  
  #progressIcon {
    width: 28px;
    height: 28px;
  }
  
  #progressIcon svg,
  #progressIcon img.stage-icon-img {
    width: 22px;
    height: 22px;
  }
}

/* Prevent unwanted margins and paddings */
.stage-timeline > *:first-child {
  margin-top: 0 !important;
  padding-top: 0 !important;
}

.stage-timeline > *:last-child {
  margin-bottom: 0 !important;
  padding-bottom: 0 !important;
}